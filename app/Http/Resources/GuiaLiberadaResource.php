<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuiaLiberadaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'empresa' => $this->empresa_id,
            'competencia' => $this->competencia,
            'financeiro_departamento_liberacao' => $this->financeiro_departamento_liberacao === 1,
            'contabilidade_departamento_liberacao' => $this->contabilidade_departamento_liberacao === 1,
            'rh_departamento_liberacao' => $this->rh_departamento_liberacao === 1,
            'liberado' => $this->liberado === 1,
            'data_envio' => $this->data_envio,
            'erro_envio' => $this->erro_envio === 1,
            'error_message' => $this->error_message,
            'sem_guia' => boolval($this->sem_guia),
        ];
    }
}
