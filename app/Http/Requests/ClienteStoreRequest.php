<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreRequest extends FormRequest
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
            'cliente.nome_completo' => ['required'],
            'cliente.cpf' => ['required', 'digits:11', 'unique:clientes,cpf'],
            'cliente.rg' => ['required', 'unique:clientes,rg'],
            'cliente.pis' => ['required', 'unique:clientes,pis'],
            'cliente.data_nascimento' => ['required', 'date_format:Y-m-d'],
            'cliente.sexo' => ['required', 'in:M,F'],
            'cliente.nacionalidade' => ['required'],
            'cliente.naturalidade' => ['required'],
            'cliente.estado_civil_id' => ['required', 'integer'],
            'cliente.profissao_id' => ['required', 'integer'],
            'cliente.qualificacao_id' => ['required', 'integer'],
            'cliente.ies_id' => ['required', 'integer'],
            'cliente.especialidade_id' => ['nullable', 'integer'],
            'cliente.url' => ['nullable'],
            'cliente.login' => ['nullable'],
            'cliente.password' => ['nullable'],
            'contatos' => ['required', 'array', 'min:2'],
            'contatos.*' => ['required', 'integer'],

            'endereco_id' => ['required', 'integer'],

            'arquivos.cnh_id' => ['nullable', 'integer'],
            'arquivos.cpf_id' => ['nullable', 'integer'],
            'arquivos.rg_id' => ['nullable', 'integer'],
            'arquivos.comprovante_de_casamento_id' => ['nullable', 'integer'],
            'arquivos.comprovante_de_residencia_id' => ['nullable', 'integer'],
            'plan_id' => ['nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'cliente.cpf.unique' => 'Eita preula, o cpf informado já está cadastrado.',
            'arquivos.cnh_id.required_without_all' => 'É obrigatório anexar pelo menos um documento com foto.',
            'arquivos.cpf_id.required_without_all' => 'É obrigatório anexar pelo menos um documento com foto.',
            'arquivos.rg_id.required_without_all' => 'É obrigatório anexar pelo menos um documento com foto.',
            'arquivos.comprovante_de_residencia_id.required' => 'É obrigatório anexar um comprovante de residência.',
        ];
    }
}
