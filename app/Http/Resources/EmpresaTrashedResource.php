<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaTrashedResource extends JsonResource
{
    public function toArray($request)
    {
        $motivo = $this->motivo_desativacao;
        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'motivo' => $motivo ? $motivo->motivo : null,
            'descricao'=> $motivo ? $motivo->descricao : null,
            'autor' => $motivo ? ($motivo->responsavel ? $motivo->responsavel->nome_completo : null) : null,
            'data_competencia' => $motivo ? $motivo->data_competencia : null,
            'data_solucitacao' => $motivo ? $motivo->updated_at : null,
            'data_enceramento' => $motivo ? $motivo->data_encerramento : null,
            'status' => 'desativada',
            'files' => $this->getArquivosEmpresaByName('Carta-de-trasferencia'),
        ];
    }
}
