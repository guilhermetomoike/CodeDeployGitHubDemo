<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComentarioStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'commentable_type' => ['required'],
            'commentable_id' => ['required', 'integer'],
            'conteudo' => ['required'],
            'status' => [''],

        ];
    }
}
