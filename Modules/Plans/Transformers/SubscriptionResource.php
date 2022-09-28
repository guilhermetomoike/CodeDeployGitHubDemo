<?php

namespace Modules\Plans\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'payer_id' => $this->id,
            'payer_name' => $this->getName(),
            'payer_type' => $this->getModelAlias(),
            'plans' => $this->plans,
            'total_price' => $this->plans ? $this->plans->sum('price') : null,
            'credit_card' => $this->cartao_credito
        ];
    }
}
