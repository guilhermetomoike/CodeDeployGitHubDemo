<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxasResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'data_vencimento' => $this->data_vencimento,
            'tipo_taxa' => $this->tipo_taxa,
            // 'status'=> $this->data_vencimento > Carbon::now()->format('Y-m-d')? 'normal': 'vencido',
            // 'empresa' => [
            //     'id' => $this->empresa->id,
            //     'razao_social' => $this->empresa->razao_social,
            // ],
            'empresas_id' =>$this->empresa_id
            // 'carteiras'=> $this->empresa->carteirasrel
        ];
        if ($this->arquivo) {
            $response['file'] = $this->arquivo;
        }
        return $response;
    }
}
