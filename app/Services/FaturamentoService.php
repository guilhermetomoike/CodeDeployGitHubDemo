<?php


namespace App\Services;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Guia;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\PDF as DomPDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;

class FaturamentoService
{
    public function makePrevisao(Collection $faturamentos)
    {
        if ($faturamentos->count() === 12) {
            return $faturamentos;
        }

        $from = $faturamentos->last()->mes ?? today()->format('Y-m-01');
        $to = (new Carbon($from))->addMonths(11)->format('Y-m-01');

        $range = new CarbonPeriod($from, '1 month', $to);

        foreach ($range as $key => $value) {

            if ($faturamentos->contains('mes', $value->format('Y-m-01'))) {
                continue;
            }

            $mes = ($faturamentos->first() && $faturamentos->first()->mes) ?
                $faturamentos->first()->mes :
                today()->format('Y-m-01');

            $isPrevisao = today()->format('Y-m-01') <= $mes;

            $faturamentos->prepend((object)[
                'faturamento' => $isPrevisao ? "20000.00" : "0",
                'mes' => $value->format('Y-m-01'),
                'previsao' => $value > competencia_atual(),
            ]);

        }

        return $faturamentos->sortByDesc('mes');

    }

    /**
     * Busca os 12 ultimos faturamentos da empresa, preenche 12 meses com previsao caso nao exista.
     *
     * @param Empresa $empresa
     * @return Collection|\Illuminate\Support\Collection
     */
    public function getFaturamento(Empresa $empresa)
    {
        $faturamentos = $empresa->faturamentos()->get();

        if ($faturamentos->count() < 12) {
            $faturamentos = $this->makePrevisao($faturamentos);
        }

        return $faturamentos;
    }

    /**
     * Busca os 12 ultimos faturamentos da empresa, preenche 12 meses com previsao caso nao exista.
     *
     * @param Empresa $empresa
     * @return Collection|\Illuminate\Support\Collection
     * @throws Exception
     */
    public function getFaturamentoDeclaracaoRenda(Empresa $empresa)
    {
        $faturamentos = $empresa->faturamentos(3)->get();

        if ($faturamentos->count() === 0) {
            throw new Exception('Declaração de renda não disponível.', 400);
        }

        return $faturamentos;
    }

    /**
     * Gera declaracao de faturamento em pdf
     *
     * @param Empresa $empresa
     * @return Dompdf
     */
    public function makePdfFaturamento(Empresa $empresa): DomPDF
    {
        $faturamento = $this->getFaturamento($empresa);

        $data = [
            'faturamentos' => $faturamento,
            'empresa' => $empresa,
            'endereco' => $empresa->endereco,
        ];

        $renderizedHtml = view('pdfDeclaracao.faturamento', $data);

        return PDF::loadHTML($renderizedHtml);
    }

    /**
     * Calcula a renda media com base no faturamento da empresa
     *
     * @param $empresa
     * @return float|int
     * @throws Exception
     */
    public function calculaRendaMedia($empresa)
    {
        $faturamento = $this->getFaturamentoDeclaracaoRenda($empresa);

        $renda_media = ($faturamento->median('faturamento') * 80) / 100;

        return $renda_media;
    }

    /**
     * Gera declaracao de renda em pdf
     *
     * @param Empresa $empresa
     * @param Cliente $cliente
     * @return Dompdf
     * @throws Exception
     */
    public function makePdfRenda(Empresa $empresa, Cliente $cliente): DomPDF
    {
        $renda_media = $this->calculaRendaMedia($empresa);
        $data = [
            'renda_media' => formata_moeda($renda_media),
            'cliente' => $cliente,
            'empresa' => $empresa,
            'profissao' => $cliente->profissao()->first(),
        ];
        $renderizedHtml = view('pdfDeclaracao.renda', $data);

        return PDF::loadHTML($renderizedHtml);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws Exception
     */
    public function makeImpostosResumeByEmpresaId(int $id)
    {
        $empresa = Empresa::find($id);

        if ($empresa->regime_tributario === 'SN') {
            $competenciaAnterior = today()->subMonths(3)->format('Y-m-01');
            $competenciaAtual = today()->subMonth()->format('Y-m-01');
        } else {
            $competenciaAnterior = trimestre()['inicio'];
            $competenciaAtual = trimestre()['fim'];
        }

        /** @var  $empresa Empresa */
        $guiasLiberacao = $empresa->guia_liberacao()
            ->select('guias_liberacao.id', 'guias_liberacao.empresa_id', 'empresas_faturamentos.faturamento', 'competencia')
            ->whereBetween('competencia', [$competenciaAnterior, $competenciaAtual])
            ->leftJoin('empresas_faturamentos', function (JoinClause $join) {
                $join->on('empresas_faturamentos.empresas_id', '=', 'guias_liberacao.empresa_id');
                $join->on('empresas_faturamentos.mes', '=', 'guias_liberacao.competencia');
            })
            ->get();

        if (!$guiasLiberacao) {
            throw new Exception('Não há dados suficiente para exibir o gráfico', 422);
        }

        $faturamentoImpostosCollection = $guiasLiberacao->transform(function ($guiaLiberacao) {
            $impostos = $guiaLiberacao->guias()
                ->where('data_competencia', $guiaLiberacao->competencia)
                ->whereNotIn('tipo', Guia::TIPOS_NAO_IMPOSTOS)
                ->get('valor')
                ->pluck('valor');
            if ($impostos) {
                $valor_impostos = $impostos->sum(function ($imposto) {
                    return array_sum($imposto ?? []);
                });
            }
            return [
                'trimestre' => ceil(explode('-', $guiaLiberacao->competencia)[1] / 3),
                'impostos' => $valor_impostos ?? 0,
                'faturamento' => (float)$guiaLiberacao->faturamento ?? 0,
                'data_competencia' => $guiaLiberacao->competencia
            ];
        });

        if (!$faturamentoImpostosCollection->count()) {
            throw new Exception('Dados insuficientes para exibir o gráfico.', 422);
        }

        return $faturamentoImpostosCollection;
    }
}
