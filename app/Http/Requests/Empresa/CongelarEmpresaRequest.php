<?php

namespace App\Http\Requests\Empresa;

use Illuminate\Foundation\Http\FormRequest;

class CongelarEmpresaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_competencia' => ['required', 'date_format:Y-m-d'],
            'empresa_id' => 'required',
            'motivo_congelamento' => 'required',
        ];
    }
}
