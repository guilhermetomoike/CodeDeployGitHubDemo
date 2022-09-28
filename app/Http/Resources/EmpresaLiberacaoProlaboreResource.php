<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaLiberacaoProlaboreResource extends JsonResource
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
            'razao_social' => $this->razao_social,
            'socios' => ClienteWithLastProlaboreResource::collection($this->socios)
        ];
    }
}
