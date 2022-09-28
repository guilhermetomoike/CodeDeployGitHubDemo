<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JuntaComercial extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'taxa_alteracao' => $this->taxa_alteracao,
            'taxa_alteracao_extra' => $this->taxa_alteracao_extra,
        ];
    }
}
