<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioPerguntaEscolhaStoreRequest extends FormRequest
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
            'questionario_pergunta_id' => ['required', 'integer', 'exists:questionario_perguntas,id'],
            'escolha' => ['string', 'max:512'],
            'tipo' => ['required', 'in:tx,im,bt'],
            'outro_informar' => ['required'],
        ];
    }
}
