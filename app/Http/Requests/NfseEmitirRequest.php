<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NfseEmitirRequest extends FormRequest
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
            'empresa_id'        => 'required',
            'cnpjTomador'       => 'required|regex:/[^0-9]{14}/',
            'valor'             => 'required',
            'email'             => 'required|email',
            'codigoAtividade'   => 'required',
            'cnae'              => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'cnpjTomador.required'      => 'Cnpj do tomador é obrigatorio',
            'cnpjTomador.regex'         => 'Formato do Cnpj do tomador está inválido',
            'valor.required'            => 'Informe um valor para a Nota de Serviço',
            'email.required'            => 'Informe um e-mail para receber a Nfse',
            'email.email'               => 'Informe um e-mail válido',
            'codigoAtividade.required'  => 'Selecione um código de atividade',
        ];
    }
}
