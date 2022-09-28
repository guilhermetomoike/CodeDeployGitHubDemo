<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionarioPerguntumResource extends JsonResource
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
            'questionario_parte_id' => $this->questionario_parte_id,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'url_imagem' => $this->url_imagem,
            'obrigatoria' => $this->obrigatoria,
            'tipo' => $this->tipo,
            'tipo_escolha' => $this->tipo_escolha,
            'min' => $this->min,
            'max' => $this->max,
            'mostrar_se_resposta' => $this->mostrar_se_resposta,
            'mostrar_se_pergunta_id' => $this->mostrar_se_pergunta_id,
            'questionarioRespostas' => QuestionarioRespostumCollection::make($this->whenLoaded('questionarioRespostas')),
        ];
    }
}
