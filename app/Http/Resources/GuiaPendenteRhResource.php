<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuiaPendenteRhResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'empresa_id' => $this->id,
            'razao_social' => $this->razao_social,
            'regime_tributario' => $this->regime_tributario,
            'socios' => SocioProlaboreAtualAnteriorResource::collection($this->socios),
        ];
    }
}
