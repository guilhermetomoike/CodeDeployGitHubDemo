<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReceivedHoleritesResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'url' => Storage::disk('s3')->temporaryUrl($this->path, now()->addMinutes(5)),
            'label' => $this->label,
            'name' => $this->name,
            'causer_type' => $this->causer_type,
            'causer_id' => $this->causer_id,
            'created_at' => $this->created_at
        ];

        if ($this->relationLoaded('causer')) {
            $response['causer'] = [
                'id' => $this->causer->id,
                'name' => $this->causer->nome_completo ?? $this->causer->razao_social,
                'cpfCnpj' => $this->causer->cpf ?? $this->causer->cnpj,
            ];
        }

        return $response;
    }
}
