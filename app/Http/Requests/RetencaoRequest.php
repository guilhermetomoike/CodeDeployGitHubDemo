<?php

namespace App\Http\Requests;

use App\Rules\Base64PDF;
use Illuminate\Foundation\Http\FormRequest;

class RetencaoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => ['integer'],
            'data_retencao' => ['required', 'date'],
            'motivo_retencao_id' => ['required', 'int'],
            'empresas_id' => ['required', 'int'],

            'descricao' => ['string', 'max:300'],

        ];
    }
}
