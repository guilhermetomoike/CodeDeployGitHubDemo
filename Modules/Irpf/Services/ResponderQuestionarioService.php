<?php

namespace Modules\Irpf\Services;

use App\Models\Cliente;
use App\Notifications\QuestionsAnsweredNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Entities\IrpfClientePendencia;
use Modules\Irpf\Entities\IrpfClienteResposta;

class ResponderQuestionarioService
{
    public function execute(int $customer_id, array $data)
    {
        try {
            DB::beginTransaction();

            $declaracao = $this->saveDeclaracao($customer_id);
            $respostaCollection = $this->saveRespostas($declaracao->id, $data);

            foreach ($respostaCollection as $resposta) {
                if ($resposta['resposta']) {
                    $this->savePendencias($declaracao, $resposta);
                }
            }

            $this->notify($customer_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function saveDeclaracao(int $customer_id)
    {
        return DeclaracaoIrpf::query()->updateOrCreate([
            'cliente_id' => $customer_id,
            'ano' => today()->subYear()->year,
        ], ['step' => 'pendencia']);
    }

    private function saveRespostas(int $declaracao_id, array $data)
    {
        $respostas = [];
        foreach ($data as $resposta) {
            $respostas[] = IrpfClienteResposta::query()->updateOrCreate(
                [
                    'declaracao_irpf_id' => $declaracao_id,
                    'irpf_questionario_id' => $resposta['id']
                ],
                [
                    'resposta' => $resposta['resposta'],
                    'quantidade' => !$resposta['resposta'] ? null : $resposta['quantidade'],
                ]
            );
        }
        return $respostas;
    }

    private function savePendencias($declaracao, $resposta)
    {
        $pendenciasDaResposta = $resposta->pendencia;

        if (!$pendenciasDaResposta) return;

        $pendenciasJaExistentes = $declaracao->pendencias()->where('irpf_pendencia_id', $pendenciasDaResposta->id)->count();

        if ($pendenciasJaExistentes >= $resposta->quantidade) return;

        $quantidadeDePendenciasParaCriar = $resposta->quantidade - $pendenciasJaExistentes;

        return Collection::times($quantidadeDePendenciasParaCriar, function () use ($pendenciasDaResposta, $resposta) {
            return IrpfClientePendencia::query()->create([
                'declaracao_irpf_id' => $resposta->declaracao_irpf_id,
                'irpf_pendencia_id' => $pendenciasDaResposta->id,
                'inputs' => $pendenciasDaResposta->inputs->toArray()
            ]);
        });
    }

    private function notify(int $customer_id)
    {
        $customer = Cliente::query()->find($customer_id);

        if ($customer) {
            $customer->notify(new QuestionsAnsweredNotification());
        }
    }
}
