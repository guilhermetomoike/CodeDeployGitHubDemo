<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioParteStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'questionario_pagina_id' => ['required', 'integer', 'exists:questionario_paginas,id'],
            'titulo' => ['string', 'max:255'],
            'subtitulo' => ['string', 'max:255'],
            'url_imagem' => ['string', 'max:512'],
        ];
    }
}
