<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CoworkingResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'data_vencimento' => $this->data_vencimento,
            'status'=> $this->data_vencimento > Carbon::now()->format('Y-m-d')? 'normal': 'vencido',
            'empresa' => [
                'id' => $this->empresa->id,
                'razao_social' => $this->empresa->razao_social,
            ],
            'carteiras'=> $this->empresa->carteirasrel
        ];
        if ($this->arquivo) {
            $response['arquivo'] = $this->arquivo;
        }
        return $response;
    }
}
