<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanoResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id'   => $this->id,
            'nome' => $this->nome,
            'valor' => $this->valor,
            'quantitativo' => $this->quantitativo,
        ];

        if($request->get('contrato')){
            $data['contrato'] = $this->contrato;
        }

        return $data;
    }
}
