<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuiaLiberacaoWithGuiaResource extends JsonResource
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
            'empresa' => $this->empresa_id,
            'competencia' => $this->competencia,
            'financeiro_departamento_liberacao' => $this->financeiro_departamento_liberacao === 1,
            'liberado' => $this->liberado === 1,
            'data_envio' => $this->data_envio,
            'erro_envio' => $this->erro_envio === 1,
            'error_message' => $this->error_message,
            'guias' => GuiaResource::collection($this->guias)
        ];
    }
}
