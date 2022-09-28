<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario'          => 'required|string|max:35',
            'nome_completo'    => 'required|string|max:255',
            'senha'            => 'required|string|max:35',
            'tipo_id'          => 'integer|exists:tipo_usuario,id',
            'ativo'            => 'boolean',
            'email'            => 'required|email|unique:usuarios,email',
            'email_integracao' => 'email',
            'senha_email'      => 'string|max:245',
            'telefone_celular' => 'string|max:25',
            'email_medb'       => 'email',
            'senha_email_medb' => 'string|max:45',
        ];
    }
}
