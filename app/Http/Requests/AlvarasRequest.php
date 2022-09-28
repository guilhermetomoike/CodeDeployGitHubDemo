<?php

namespace App\Http\Requests;

use App\Rules\Base64PDF;
use Illuminate\Foundation\Http\FormRequest;

class AlvarasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_vencimento' => ['required', 'date'],
            'empresa_id' => ['required', 'exists:empresas,id'],
            'file' => ['required_if:' . request()->method() == 'post', new Base64PDF]
        ];
    }
}
