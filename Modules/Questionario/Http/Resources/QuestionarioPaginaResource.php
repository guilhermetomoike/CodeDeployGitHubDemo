<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionarioPaginaResource extends JsonResource
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
            'questionario_id' => $this->questionario_id,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'questionario_partes' => QuestionarioParteCollection::make($this->whenLoaded('questionarioPartes')),
        ];
    }
}
