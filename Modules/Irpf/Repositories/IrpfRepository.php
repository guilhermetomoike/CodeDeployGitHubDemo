<?php


namespace Modules\Irpf\Repositories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfClienteResposta;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\DB;

class IrpfRepository
{
    public function storeRespostas(array $data, int $cliente_id)
    {
        DB::transaction(function () use ($data, $cliente_id) {
            $declaracao = Cliente::find($cliente_id)->declaracao_irpf;

            // percorre o array de respostas/perguntas e cria registros de respostas
            foreach ($data['respostas'] as &$item) {
                // joga exception caso alguma pergunta estiver sem resposta
                abort_if(!isset($item['resposta']), 422, "Faltando responder {$item['pergunta']}.");
                $declaracao->items()->create([
                    'declaracao_irpf_id' => $declaracao->id,
                    'irpf_questionario_id' => $item['id'],
                    'resposta' => $item['resposta'],
                    'quantidade' => $item['quantidade'] ?? null,
                ]);
            }

            // cria registro de resposta default referente ao informe bancario
            $declaracao->items()->create([
                'declaracao_irpf_id' => $declaracao->id,
                'irpf_questionario_id' => 11,
                'resposta' => 1,
            ]);

            // muda o status da declaracao para pendencia
            $declaracao->update(['step' => 'pendencia']);
        });

        return true;
    }

    public function getPendenciaByClienteId(int $cliente_id)
    {
        $pendencia = DeclaracaoIrpf::with(['items' => function (HasMany $item) {
            $item->select(['irpf_cliente_resposta.id', 'irpf_cliente_resposta.irpf_questionario_id', 'irpf_cliente_resposta.declaracao_irpf_id',])
                ->join('irpf_questionario', 'irpf_questionario.id', '=', 'irpf_cliente_resposta.irpf_questionario_id')
                ->where('resposta', 1)
                ->with(['pendencias' => function (HasOneThrough $pendencia) {
                    $pendencia
                        ->select('irpf_pendencia.id', 'nome', 'descricao', 'irpf_questionario_id')
                        ->with(['inputs' => function (HasMany $input) {
                            $input->select('id', 'irpf_pendencia_id', 'type', 'label', 'name');
                        }]);
                }])
                ->with(['enviados']);
        }])->where('cliente_id', $cliente_id)->first();

        return $pendencia;
    }

    public function finalizaDeclaracao(int $cliente_id, array $data): Model
    {
        return DeclaracaoIrpf
            ::query()
            ->updateOrCreate(
                ['cliente_id' => $cliente_id, 'ano' => $data['ano']],
                [
                    'realizacao' => 'interno',
                    'step' => 'finalizado',
                    'qtd_lancamento' => $data['qtd_lancamento'],
                    'rural' => $data['rural'],
                    'ganho_captal' => $data['ganho_captal'],
                ]
            );
    }

    public function getClientesList(string $ano)
    {
        return Cliente::query()
            ->select('id', 'nome_completo')
            ->with([
                'empresa:id,razao_social',
                'empresa.contrato',
                'empresa.carteiras' => function ($query) {
                    $query->where('setor', 'contabilidade');
                },
                'irpf' => function ($query) use ($ano) {
                    $query->where('ano', $ano);
                },
                'irpf.resposta.pendencia',
                'irpf.pendencias',
                'irpf.arquivos',
            ])
            ->get();
    }

}
