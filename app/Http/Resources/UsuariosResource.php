<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuariosResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'usuario' => $this->usuario,
            'nome_completo' => $this->nome_completo,
            'email' => $this->email,
            'email_integracao' => $this->email_integracao,
            'telefone_celular' => $this->telefone_celular,
            'email_medb' => $this->email_medb,
            'role' => $this->roles->pluck('name'),
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'deleted_at' => $this->deleted_at,
        ];
    }
}
