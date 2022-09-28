<?php

namespace Modules\Invoice\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodsShowResource extends JsonResource
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
            'id' => $this->id,
            'ano' => (string)$this->ano,
            'mes' => $this->mes,
            'cartao_truncado' => $this->cartao_truncado,
            'dono_cartao' => $this->dono_cartao,
            'invalido' => $this->invalido,
            'principal' => $this->principal,
            'payer_type' => $this->payer_type,
            'payer_id' => $this->payer_id,
        ];
    }
}
