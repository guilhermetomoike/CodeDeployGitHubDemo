<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuiaResource extends JsonResource
{
    public function toArray($request)
    {
        $path = $this->nome_guia;
        return [
            'id' => $this->id,
            'nome' => $this->arquivo->nome_original ?? null,
            'path' => $path,
            'arquivo_id' => $this->arquivo ? $this->arquivo->id ?? null : null,
            'tipo' => $this->tipo,
            'data_upload' => $this->data_upload,
            'data_vencimento' => $this->data_vencimento,
        ];
    }
}
