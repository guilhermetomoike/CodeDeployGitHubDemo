<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $data = [
            'precadastro.tipo' => ['required', 'in:abertura,transferencia'],
            'precadastro.data_inicio_cobranca' => ['nullable'],
            'precadastro.empresa.razao_social' => ['nullable', 'array', 'min:1', Rule::requiredIf($this->precadastro['tipo'] == 'abertura')],
            'precadastro.empresa.observacoes' => ['nullable'],

            'comprovante_residencia_id' => ['nullable', 'integer', 'exists:arquivos,id'],
            'cartao_cnpj_id' => ['nullable', 'integer', 'exists:arquivos,id'],

            'empresa.cnpj' => ['nullable', 'digits:14', Rule::requiredIf($this->precadastro['tipo'] == 'transferencia')],
            'empresa.razao_social' => ['nullable', Rule::requiredIf($this->precadastro['tipo'] == 'transferencia')],
            'empresa.nome_fantasia' => ['required'],
            'empresa.regime_tributario' => ['required', 'in:SN,Presumido,Isento'],
            'empresa.tipo_societario' => ['required', 'in:LTDA,Eireli,Individual,Unipessoal,ONG'],
            'empresa.clinica_fisica' => ['required', 'boolean'],
            'empresa.type' => ['required'],

            'contatos' => ['required', 'array', 'min:2'],
            'contatos.*' => ['required', 'integer', 'exists:contatos,id'],

            'endereco_id' => ['required', 'integer', 'exists:enderecos,id'],

            'socios' => ['required', 'array', 'min:1'],
            'socios.*.cliente_id' => ['required', 'integer', 'exists:clientes,id'],
            'socios.*.porcentagem_societaria' => ['required', 'integer'],
            'socios.*.socio_administrador' => ['nullable', 'boolean'],

            'plan_id' => ['required', 'integer', 'exists:plans,id'],
        ];

        return $data;
    }
}
