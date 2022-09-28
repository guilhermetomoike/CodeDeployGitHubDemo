<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioPaginaStoreRequest extends FormRequest
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
            'questionario_id' => ['required', 'integer', 'exists:questionarios,id'],
            'titulo' => ['string', 'max:255'],
            'subtitulo' => ['string', 'max:255'],
        ];
    }
}
