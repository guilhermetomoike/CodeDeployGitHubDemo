<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmContactsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            '*.tipo' => ['required', 'in:email,celular'],
            '*.value' => ['required'],
            '*.optin' => ['required', 'boolean'],
            '*.options' => ['nullable'],
        ];

        if ($this->tipo == 'email') {
            $rules['value'] = ['required', 'email'];
        }

        if ($this->tipo == 'celular') {
            $rules['value'] = ['required', 'digits:11'];
        }

        return $rules;
    }
}
