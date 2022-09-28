<?php

namespace Modules\Irpf\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class IrpfQuestionarioPendenciaResource extends JsonResource
{
    public function toArray($request)
    {
        $resposta = $this->resposta;
        return [
            'id' => $this->id,
            'pergunta' => $this->pergunta,
            'descricao' => $this->descricao ?? '',
            'ativo' => $this->ativo,
            'order' => $this->order,
            'quantitativo' => $this->quantitativo,
            'visivel_cliente' => $this->visivel_cliente,
            'resposta' => $resposta ? $resposta->resposta : null,
            'quantidade' => $resposta ? intval($resposta->quantidade) : null,
            'answered_at' => $resposta ? $resposta->created_at : null,
        ];
    }
}
