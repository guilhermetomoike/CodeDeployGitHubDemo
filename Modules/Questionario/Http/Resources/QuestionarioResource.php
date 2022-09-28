<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionarioResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'questionario_paginas' => QuestionarioPaginaCollection::make($this->whenLoaded('questionarioPaginas')),
        ];
    }
}
