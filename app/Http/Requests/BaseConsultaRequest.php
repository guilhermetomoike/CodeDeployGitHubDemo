<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseConsultaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'per_page' => 'numeric',
            'page'     => 'numeric',
            'search'   => 'max:255'
        ];
    }
}
