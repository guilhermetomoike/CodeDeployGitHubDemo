<?php

namespace App\Http\Requests;

use App\Rules\Base64PDF;
use Illuminate\Foundation\Http\FormRequest;

class SatisfacaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cpf' => ['required', 'string'],
            'comentario' => [ 'string','max:500'],
            'satisfacao' => ['required', 'int'],

      
        ];
    }
}
