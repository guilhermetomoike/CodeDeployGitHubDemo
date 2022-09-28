<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaGuiaLiberacaoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'regime_tributario' => $this->regime_tributario,
            'guia_liberacao' => GuiaLiberadaResource::collection($this->guia_liberacao),
            'guias' => GuiaResource::collection($this->guias),
            'pagamento_cartao' => (bool)($this->cartao_credito->count()),
            'carteiras' => $this->carteiras,
        ];
    }
}
