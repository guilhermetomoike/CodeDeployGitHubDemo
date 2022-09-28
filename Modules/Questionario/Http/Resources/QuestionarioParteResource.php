<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionarioParteResource extends JsonResource
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
            'questionario_pagina_id' => $this->questionario_pagina_id,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'url_imagem' => $this->url_imagem,
            'questionario_perguntas' => QuestionarioPerguntumCollection::make($this->whenLoaded('questionarioPerguntas')),
        ];
    }
}
