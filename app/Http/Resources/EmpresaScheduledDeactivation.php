<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaScheduledDeactivation extends JsonResource
{
    public function toArray($request)
    {
        $motivo = $this->motivo_desativacao;

        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'motivo' => $motivo ? $motivo->descricao : null,
            'autor' => $motivo ? ($motivo->responsavel ? $motivo->responsavel->nome_completo : null) : null,
            'data' => $motivo ? $motivo->updated_at : null,
            'status' => 'Desativação Agendada'
        ];
    }
}
