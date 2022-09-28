<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceitasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
            'cliente_nome' => $this->cliente->nome_completo,
            'fator_r' => $this->fator_r,
            'inss' => $this->inss,
            'lancado' => $this->lancado === 1,
            'competencia_atual' => $this->data_competencia,
            'prolabore_atual' => $this->prolabore,
            'competencia_anterior' => $this->competencia_anterior,
            'prolabore_anterior' => $this->prolabore_anterior,
            'arquivo_id' => $this->arquivo ? $this->arquivo->id : null,
            'arquivo_nome' => $this->arquivo ? $this->arquivo->nome_original : null,
            'anterior' => $this->anterior,
        ];
    }
}
