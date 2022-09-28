<?php

namespace Modules\Questionario\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionarioPerguntaEscolhaCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
