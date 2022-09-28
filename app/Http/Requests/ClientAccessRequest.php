<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientAccessRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => ['required'],
            'password' => ['required'],
            'url' => ['required', 'url'],
            'type' => ['required', 'in:meu_inss']
        ];
    }
}
