<?php

namespace Modules\Invoice\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ContasReceberResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'payer_id' => $this->payer_id,
            'payer_type' => $this->payer_type,
            'payer_name' => $this->payer->getName(),
            'valor' => $this->valor,
            'vencimento' => $this->vencimento,
            'consumed_at' => $this->consumed_at,
            'descricao' => $this->descricao,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
