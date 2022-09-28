<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlterarSenhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'senha' => ['required', 'string', 'min:6', 'max:250'],
            'confirma_senha' => ['required', 'same:senha'],
            'senha_atual' => ['required', 'string'],
        ];
    }
}
