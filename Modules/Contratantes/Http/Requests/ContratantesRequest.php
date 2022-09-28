<?php

namespace Modules\Contratantes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratantesRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'nome' => ['required', 'string'],
            'endereco.iptu' => ['nullable'],
            'endereco.cep' => ['required', 'size:8'],
            'endereco.logradouro' => ['required'],
            'endereco.numero' => ['required'],
            'endereco.complemento' => ['nullable'],
            'endereco.bairro' => ['required'],
            'endereco.cidade' => ['required'],
            'endereco.uf' => ['required', 'size:2'],
            'endereco.ibge' => ['nullable', 'size:7'],
            'email' => ['required', 'email'],
            'celular' => ['required', 'digits:11']
        ];

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
