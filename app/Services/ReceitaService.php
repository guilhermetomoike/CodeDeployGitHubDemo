<?php

namespace App\Services;

use App\Models\Carteira;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Receita;
use App\Models\Upload;
use App\Modules\ConvertBase64ToFile;
use App\Repositories\GuialiberacaoRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReceitaService
{
    private $fileService;

    public function __construct(\App\Services\File\FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function getReceitas(Request $request)
    {
        $carteira_id = $request->get('carteira');
        $filterLancados = (boolean)$request->get('filterLancados', false);
        $competencia = $request->get('dataCompetencia', competencia_atual());
        $competenciaAnterior = Carbon::createFromFormat('Y-m-d', $competencia)->subMonth();

        $receitas = Receita::getFilteredList($competencia, $carteira_id, $filterLancados);

        $receitas->map(function (Receita $receita) use ($competenciaAnterior) {
            return $receita->findAddCompetenciaAnterior($competenciaAnterior);
        });

        return [
            'items' => $receitas,
            'competenciaAnterior' => $competenciaAnterior,
            'competenciaAtual' => $competencia,
        ];
    }

    public function create(array $request)
    {
        $empresaId = $request['empresa'];
        $socios = $request['socios'];

        $empresa = Empresa::findOrFail($empresaId);
        abort_if(!$empresa->cnpj, 422, 'Empresa sem CNPJ cadastrado.');
        $competencia = $request['competencia'];

        $file = null;
        if (array_key_exists('file_id', $request)) {
            $file = Upload::find($request['file_id']);
        }

        foreach ($socios as $socio) {
            $cliente = Cliente::findOrFail($socio['id']);
            $receita = Receita::updateOrCreate([
                'cliente_id' => $cliente->id,
                'empresa_id' => $empresa->id,
                'data_competencia' => $competencia,
            ], [
                'cnpj' => $empresa->cnpj,
                'prolabore' => $socio['prolabore'],
            ]);

            if ($file) {
                $receita
                    ->arquivo()
                    ->create(['nome_original' => $file->name, 'caminho' => $file->path]);
            }
        }

        if ($file) {
            $file->delete();
        } else {
            // quando nao houver upload de arquivo considera um lançamento manual
            // de emmpresa sem movimento, portanto não haverá guia de imposto de contabilidade
            // e deve ser realizado a liberacao da contabilidade automaticamente
            $liberacao = ['contabilidade_departamento_liberacao' => true];
            (new GuiaService(new GuialiberacaoRepository))
                ->changeLiberacao($liberacao, $empresa->id, $competencia);
        }

    }

    public function edit(int $id, array $data)
    {
        $receita = Receita::findOrFail($id);
        $receita->prolabore = $data['prolabore'];
        $receita->save();
    }

    public function editDivisaoReceitas(array $socios)
    {
        foreach ($socios as $socio) {
            $empresa = Empresa::find($socio['empresa_id']);
            $data = [
                'prolabore_fixo' => $socio['prolabore_fixo'],
                'valor_prolabore_fixo' => $socio['prolabore_fixo'] ? $socio['valor_prolabore_fixo'] : 0,
                'percentual_prolabore' => !$socio['prolabore_fixo'] ? $socio['percentual_prolabore'] : 0,
            ];
            $empresa
                ->socios()
                ->syncWithoutDetaching([$socio['id'] => $data]);
        }
    }

    public function calcProlabore(array $data)
    {
        if ($data['rpa'] > 15000) {
            return $data['rpa'] * 0.28;
        }
        if ($data['fatorR'] >= 0.40) {
            return ($data['rpa'] * 0.28) - $data['cpp'];
        }
        if ($data['fatorR'] < 0.40 && $data['fatorR'] >= 0.30) {
            return $data['rpa'] * 0.28;
        }
        return $data['rpa'] * 0.30;
    }

    public function deleteReceita(int $id)
    {
        Receita::destroy($id);
    }

    public function generateReport(Request $request)
    {
        $data = $this->getReceitas($request);
        $data = [
            'items' => $data['items']->map(function ($item) {
                $item->prolabore_anterior = $item->prolabore_anterior ? 'R$ ' . $item->prolabore_anterior : 'R$ 0.00';
                $item->prolabore = $item->prolabore ? 'R$ ' . $item->prolabore : 'R$ 0.00';
                return $item;
            })->sortBy('empresa_id'),
            'competenciaAnterior' => date_to_format($data['competenciaAnterior'], 'm/Y'),
            'competenciaAtual' => date_to_format($data['competenciaAtual'], 'm/Y'),
        ];

        $pdf = PDF::loadView('reports.receitas', ['data' => $data]);
        return $pdf->download('receitas.pdf');
    }

    public function roundProlaboreVariavel(int $prolabore, float $fatorR): int
    {
        if ($prolabore > 0 && $prolabore < 1212 ) {
            return 1212;
        }
        if ($fatorR >= 0.32) {
            return floor(($prolabore / 100)) * 100;
        }
        return ceil(($prolabore / 100)) * 100;
    }

    public static function criarReceitasParaEmpresasComLucroPresumido()
    {
        $empresas = Empresa
            ::query()
            ->with('socios')
            ->where('regime_tributario', 'Presumido')
            ->get();

        foreach ($empresas as $empresa) {
            foreach ($empresa->socios as $socio) {
                $prolabore = salario_minimo();
                if ($socio->pivot->prolabore_fixo && $socio->pivot->valor_prolabore_fixo > 0) {
                    $prolabore = $socio->pivot->valor_prolabore_fixo;
                }

                if (
                    (!$socio->pivot->prolabore_fixo && $socio->pivot->percentual_prolabore > 0)
                    || ($socio->pivot->prolabore_fixo && $socio->pivot->valor_prolabore_fixo == 0)
                ) {
                    continue;
                }

                Receita::updateOrCreate([
                    'cliente_id' => $socio->id,
                    'empresa_id' => $empresa->id,
                    'data_competencia' => competencia_anterior(),
                ], [
                    'cnpj' => $empresa->cnpj,
                    'prolabore' => $prolabore,
                ]);
            }
        }
    }

    public function lancamentoReceita(array $data, int $id)
    {
        $receita = Receita::find($id);
        $receita->lancado = $data['lancado'];
        $receita->save();
    }

    public function getYearlyByCustomer($customer_id)
    {
        $dateTime = Carbon::now()->firstOfMonth();
        $dataFim = $dateTime->setMonth(11)->format('Y-m-d');
        $dataInicio = $dateTime->subYears(1)->setMonth(12)->format('Y-m-d');
        $result = [];

        $receitas = Receita::query()
            ->whereBetween('data_competencia', [$dataInicio, $dataFim])
            ->where('cliente_id', $customer_id)
            ->with('arquivo')
            ->get()
            ->groupBy('data_competencia');

        $monthRange = CarbonPeriod::create($dataInicio, '1 month', $dataFim);

        $monthRange->forEach(function ($date) use (&$result, $receitas) {
            $result[$date->toDateString()] = $receitas[$date->toDateString()] ?? [];
        });

        return new Collection($result);
    }

    public function storeHolerite(array $data)
    {
        $receita = Receita::query()->create($data);
        $upload = $data['file'] ?? null;
        if ($upload && $upload['base64']) {
            $receita = $this->attachFile($upload, $receita);
        }

        return $receita;
    }

    public function updateHolerite(int $id, array $data)
    {
        $receita = Receita::find($id);
        $receita->cnpj = $data['cnpj'];
        $receita->prolabore = $data['prolabore'];
        $receita->inss = $data['inss'];
        $receita->irrf = $data['irrf'];
        $receita->save();

        $upload = $data['file'] ?? null;
        if ($upload && $upload['base64']) {
            $receita = $this->attachFile($upload, $receita);
        }
        return $receita;
    }

    public function attachFile($upload, $receita)
    {
        $upload = ConvertBase64ToFile::run($upload['base64']);
        $extension = (new \finfo(FILEINFO_EXTENSION))->buffer($upload);
        $path = Str::random() . '.' . $extension;

        Storage::disk('s3')->put($path, $upload);

        $file = $receita->arquivo()->create([
            'nome' => 'holerite',
            'caminho' => $path,
            'nome_original' => $path
        ]);

        $receita['arquivo'] = $file;

        return $receita;
    }

    public function moveUploadToHolerite(array $data)
    {
        $upload = Upload::query()->find($data['id']);

        try {
            DB::beginTransaction();
            $receita = Receita::query()->create([
                'cliente_id' => $data['causer_id'],
                'cnpj' => $data['cnpj'],
                'prolabore' => $data['prolabore'],
                'inss' => $data['inss'],
                'irrf' => $data['irrf'],
                'data_competencia' => $data['data_competencia'],
            ]);

            $receita->arquivo()->create([
                'nome' => 'holerite',
                'caminho' => $upload->path,
                'nome_original' => $upload->nome_original,
            ]);

            $upload->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Não foi pssível realizar a operação. ' . $e->getMessage());
        }

        return $receita;
    }
}
