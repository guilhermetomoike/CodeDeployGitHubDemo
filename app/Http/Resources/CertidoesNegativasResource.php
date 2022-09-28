<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CertidoesNegativasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
            'empresa_nome' => $this->empresa->razao_social,
            'tipo' => $this->tipo,
            'data_emissao' => $this->data_emissao,
            'data_validade' => $this->data_validade,
            'arquivo_id' => $this->arquivo ? $this->arquivo->id : null,
            'arquivo_nome' => $this->arquivo ? $this->arquivo->nome_original : null,
        ];
    }
}
