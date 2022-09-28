<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcessoPrefeituraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'login' => ['required'],
            'senha' => ['required'],
            'site' => ['required', 'url'],
            'tipo' => ['required', 'in:emissor,alvara,prefeitura,deiss']
        ];
    }
}
