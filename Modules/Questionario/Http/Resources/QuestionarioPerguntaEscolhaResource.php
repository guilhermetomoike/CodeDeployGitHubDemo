<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionarioPerguntaEscolhaResource extends JsonResource
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
            'questionario_pergunta_id' => $this->questionario_pergunta_id,
            'escolha' => $this->escolha,
            'tipo' => $this->tipo,
            'outro_informar' => $this->outro_informar,
        ];
    }
}
