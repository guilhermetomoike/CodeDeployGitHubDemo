<?php

namespace Modules\Invoice\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'payer_id' => $this->id,
            'payer_name' => $this->getName(),
            'payer_type' => $this->getModelAlias(),
            'cartao_credito' => $this->cartao_credito->transform(fn($cc) => [
                'cartao_truncado' => $cc->cartao_truncado,
                'dono_cartao' => $cc->dono_cartao,
                'vencimento' => "{$cc->mes}/{$cc->ano}",
            ])
        ];
    }
}
