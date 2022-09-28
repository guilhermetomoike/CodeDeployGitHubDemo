<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertidaoNegativaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'empresa' => 'required',
            'tipo' => 'required',
            'data_emissao' => 'required',
            'data_validade' => 'required',
            'file' => 'required',
        ];
    }
}
