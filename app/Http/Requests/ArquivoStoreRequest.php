<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArquivoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'arquivo' => ['required', 'file'],
            'nome' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
            'model_id' => ['nullable', 'integer'],
            'model_type' => ['nullable', 'string'],
        ];
    }
}
