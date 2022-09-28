<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GuiasNaoProcessadasResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nome' => $this->name,
            'url' => Storage::disk('s3')->temporaryUrl($this->path, now()->addMinutes(5)),
            'data_competencia' => $this->data_competencia,
            'error_message' => $this->error_message,
        ];
    }
}
