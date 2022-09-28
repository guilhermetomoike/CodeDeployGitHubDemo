<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioPerguntumStoreRequest extends FormRequest
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
            'questionario_parte_id' => ['required', 'integer', 'exists:questionario_partes,id'],
            'titulo' => ['string', 'max:512'],
            'subtitulo' => ['string', 'max:512'],
            'url_imagem' => ['string', 'max:512'],
            'obrigatoria' => ['required'],
            'tipo' => ['required', 'in:me,ue,tl,tc,dt,nu,vl,in,or'],
            'tipo_escolha' => ['in:hz,vt,cb'],
            'min' => ['required', 'integer'],
            'max' => ['required', 'integer'],
            'mostrar_se_resposta' => ['required', 'string', 'max:512'],
            'mostrar_se_pergunta_id' => ['integer', 'exists:mostrar_se_perguntas,id'],
        ];
    }
}
