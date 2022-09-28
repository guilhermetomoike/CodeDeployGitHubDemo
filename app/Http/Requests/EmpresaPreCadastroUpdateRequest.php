<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaPreCadastroUpdateRequest extends FormRequest
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
            'empresa.regime_tributario' => ['sometimes', 'required', 'in:SN,Presumido'],
            'empresa.tipo_societario' => ['sometimes', 'required', 'in:LTDA,Eireli,Individual,Unipessoal'],
            'empresa.clinica_fisica' => ['sometimes', 'required', 'boolean'],
            'empresa.nome_fantasia' => ['sometimes', 'nullable', 'string'],
            'empresa.type' => ['sometimes', 'required', 'string'],

            'precadastro.tipo' => ['sometimes', 'string'],
            'precadastro.empresa.observacoes' => ['sometimes', 'nullable'],
            'precadastro.empresa.razao_social' => ['nullable', 'array', 'min:1', Rule::requiredIf($this->precadastro['tipo'] == 'abertura')],
            'arquivo_contrato_id' =>['sometimes', 'nullable'],

            'endereco.id' => ['sometimes', 'nullable'],
            'endereco.iptu' => ['sometimes', 'required'],
            'endereco.cep' => ['sometimes', 'required', 'size:8'],
            'endereco.logradouro' => ['sometimes', 'required'],
            'endereco.numero' => ['sometimes', 'required'],
            'endereco.complemento' => ['sometimes', 'nullable'],
            'endereco.bairro' => ['sometimes', 'required'],
            'endereco.cidade' => ['sometimes', 'required'],
            'endereco.uf' => ['sometimes', 'required', 'size:2'],
            'endereco.ibge' => ['sometimes', 'required', 'size:7'],
            'endereco.tipo' => ['sometimes', 'nullable'],

            'contatos' => ['sometimes', 'required', 'array', 'min:2'],
            'contatos.*.tipo' => ['sometimes', 'required', 'in:email,celular'],
            'contatos.*.value' => ['sometimes', 'required'],
            'contatos.*.optin' => ['sometimes', 'required', 'boolean'],
            'contatos.*.options' => ['sometimes', 'nullable'],
            'contatos.*.options.is_whatsapp' => ['sometimes', 'nullable', 'boolean'],

            'plan_id' => ['sometimes', 'required', 'integer', 'exists:plans,id'],

            'socios' => ['sometimes', 'required', 'array', 'min:1'],
            'socios.*.cliente_id' => ['sometimes', 'required', 'integer', 'exists:clientes,id'],
            'socios.*.porcentagem_societaria' => ['sometimes', 'required', 'integer'],
            'socios.*.socio_administrador' => ['sometimes', 'nullable', 'boolean'],
        ];

        if ($this->tipo == 'abertura') {
            $rules['empresa.razao_social'] = ['sometimes', 'required', 'array', 'min:3'];
        }

        if ($this->tipo == 'transferencia') {
            $rules['empresa.cnpj'] = ['sometimes', 'required', 'digits:14'];
            $rules['empresa.razao_social'] = ['sometimes', 'required'];

            $rules['precadastro.empresa.razao_social'] = ['sometimes', 'required'];
        }

        return $rules;
    }
}
