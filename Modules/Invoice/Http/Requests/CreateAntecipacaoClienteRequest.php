<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAntecipacaoClienteRequest extends FormRequest
{

    public function rules()
    {
        return [
    
            'data_competencia' => ['required', 'date'],
            'payer_id' => ['required', 'integer'],
            'payer_type' => ['required', 'in:cliente,empresa']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
