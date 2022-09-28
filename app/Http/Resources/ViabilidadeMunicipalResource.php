<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViabilidadeMunicipalResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' =>  $this->id,
            'cidade' => $this->cidade->nome,
            'estado' => $this->cidade->estado->nome,
            'updated_at' => $this->updated_at,
        ];
    }
}
