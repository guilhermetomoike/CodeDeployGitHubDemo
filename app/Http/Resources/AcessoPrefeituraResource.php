<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AcessoPrefeituraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'senha' => $this->senha,
            'tipo' => $this->tipo,
            'site' => $this->site
        ];
    }
}
