<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DivisaoReceitasRequest extends FormRequest
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
            'somaPercentual' => ['required', Rule::in([100])],
            'socios' => 'required',
            'socios.*.id' => 'required',
            'socios.*.empresa_id' => 'required',
            'socios.*.prolabore_fixo' => 'required',
            'socios.*.valor_prolabore_fixo' => 'required_if:prolabore_fixo,true',
            'socios.*.percentual_prolabore' => 'required_if:prolabore_fixo,false',
        ];
    }

    public function messages()
    {
        return [
            'somaPercentual.*' => 'A soma do percentual de prolabore dos Sócios deve ser igual a 100%',
        ];
    }
}
