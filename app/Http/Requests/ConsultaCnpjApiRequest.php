<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaCnpjApiRequest extends FormRequest
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
            'cnpj' => 'unique:tomador_nfse,cpf_cnpj|required',
        ];
    }

    public function messages()
    {
        return [
            'cnpj.unique' => 'O CNPJ informado já está cadastrado no sistema',
            'cnpj.required' => 'O CNPJ é obrigatório',
        ];
    }
}
