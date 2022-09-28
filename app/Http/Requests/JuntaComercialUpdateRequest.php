<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JuntaComercialUpdateRequest extends FormRequest
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
            'estado_id' => 'required|integer|exists:estados,id',
            'taxa_alteracao' => 'required|numeric|between:-999999.99,999999.99',
            'taxa_alteracao_extra' => 'nullable|numeric|between:-999999.99,999999.99',
        ];
    }
}
