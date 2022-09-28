<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CertidoesNegativasNaoProcessadasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'url' => Storage::disk('s3')->temporaryUrl($this->path, now()->addMinutes(5)),
            'error_message' => $this->error_message,
            'created_at' => $this->created_at,
        ];
    }
}
