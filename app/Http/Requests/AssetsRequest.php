<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => ['required'],
            'code' => ['required'],
            'description' => ['required'],
            'value' => ['required'],
            'next_confirmed' => ['nullable', 'boolean']
        ];
    }
}
