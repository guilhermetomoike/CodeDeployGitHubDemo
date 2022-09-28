<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioRespostumUpdateRequest extends FormRequest
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
            'questionario_pergunta_escolha_id' => ['integer', 'exists:questionario_pergunta_escolhas,id'],
            'respondente' => ['required', 'string', 'max:255'],
            'resposta' => ['string', 'max:512'],
        ];
    }
}
