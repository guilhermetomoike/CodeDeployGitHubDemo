<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OsBaseValidator extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'required',
            'descricao' => 'required',
            'role_id' => 'required|exists:roles,id',
            'procedimento_interno' => 'required|boolean',
            'preco' => 'required|numeric',
            'pagamento_antecipado' => 'required|boolean',
            'notificacao' => 'required|boolean',
            'atividades' => 'required|array|min:1',
            'atividades.*.nome' => 'required',
            'atividades.*.descricao' => 'required',
            'atividades.*.sla_hora' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Você deve inserir um nome para a ordem de serviço base.',
            'descricao.required' => 'Você deve inserir uma descrição para ordem de servico base.',
            'role_id.required' => 'Você deve informar o setor responsável desta ordem de serviço base.',
            'role_id.exists' => 'O setor responsável desta ordem de serviço base deve ser válido.',
            'preco.required' => 'Você deve informar o preço desta ordem de serviço base.',
            'preco.numeric' => 'O preço desta ordem de serviço base deve ser válido.',
            'procedimento_interno.required' => 'Você deve informar se a ordem de serviço é interna ou não',
            'procedimento_interno.boolean' => 'O valor do campo procedimento interno deve ser válido',
        ];
    }
}
