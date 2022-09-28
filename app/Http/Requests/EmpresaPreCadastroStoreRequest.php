<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaPreCadastroStoreRequest extends FormRequest
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
        $rules = [
            'tipo' => ['required', 'in:abertura,transferencia'],
            'comprovante_residencia_id' => ['required', 'exists:arquivos,id'],

            'empresa.regime_tributario' => ['required', 'in:SN,Presumido'],
            'empresa.tipo_societario' => ['required', 'in:LTDA,Eireli,Individual,Unipessoal'],
            'empresa.clinica_fisica' => ['required', 'boolean'],
            'empresa.nome_fantasia' => ['required'],
            'empresa.razao_social' => ['required', 'array'],
            'empresa.observacao' => ['nullable'],

            'empresa.contatos' => ['required', 'array', 'min:2'],
            'empresa.contatos.*.tipo' => ['required', 'in:email,celular'],
            'empresa.contatos.*.value' => ['required'],
            'empresa.contatos.*.optin' => ['required', 'boolean'],
            'empresa.contatos.*.options' => ['nullable'],
            'empresa.contatos.*.options.is_whatsapp' => ['nullable', 'boolean'],

            'empresa.endereco.cep' => ['required', 'array'],
            'empresa.endereco.iptu' => ['required'],
            'empresa.endereco.cep' => ['required', 'size:8'],
            'empresa.endereco.logradouro' => ['required'],
            'empresa.endereco.numero' => ['required'],
            'empresa.endereco.complemento' => ['nullable'],
            'empresa.endereco.bairro' => ['required'],
            'empresa.endereco.cidade' => ['required'],
            'empresa.endereco.uf' => ['required', 'size:2'],
            'empresa.endereco.ibge' => ['required', 'size:7'],
            'empresa.endereco.tipo' => ['nullable'],

            'empresa.socios' => ['required', 'array', 'min:1'],
            'empresa.socios.*.cliente_id' => ['required', 'integer'],
            'empresa.socios.*.porcentagem_societaria' => ['required', 'integer'],
            'empresa.socios.*.socio_administrador' => ['nullable', 'boolean'],

            'empresa.planos' => ['required', 'array', 'min:1'],
            'empresa.planos.*.plano_id' => ['required', 'integer'],
            'empresa.planos.*.quantidade' => ['required', 'integer'],
        ];

        if ($this->tipo == 'abertura') {
            $rules['empresa.razao_social'] = ['required', 'array', 'min:3'];
        }

        if ($this->tipo == 'transferencia') {
            $rules['empresa.cnpj'] = ['required', 'digits:14'];
            $rules['empresa.razao_social'] = ['required', 'array', 'max:1'];
        }

        return $rules;
    }
}
