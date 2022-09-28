<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerIndicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => ['required', 'exists:clientes,id'],
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'unique:invites,invitee_email'],
            'telefone' => ['required', 'string', 'min:8', 'max:17'],
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'Este e-mail já esta na nossa lista de indicados.',
            'cpf.unique' => 'O cpf já esta na nossa lista de indicados',
        ];
       
    }
}
