<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'tipo' => ['required', 'in:email,celular'],
            'value' => ['required'],
            'optin' => ['required', 'boolean'],
            'options' => ['nullable'],
            'options.is_whatsapp' => ['nullable', 'boolean'],
        ];

        if ($this->tipo == 'email') {
            $rules['value'] = ['required', 'email'];
        }

        if ($this->tipo  == 'celular') {
            $rules['value'] = ['required', 'digits:11'];
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'value' => 'contato',
        ];

        if ($this->tipo == 'email') {
            $attributes['value'] = 'email';
        }

        if ($this->tipo  == 'celular') {
            $attributes['value'] = 'celular';
        }

        return $attributes;
    }
}
