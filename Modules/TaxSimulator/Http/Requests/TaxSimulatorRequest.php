<?php

namespace Modules\TaxSimulator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxSimulatorRequest extends FormRequest
{

    public function rules()
    {
        return [
            'value' => ['required'],
            'iss' => ['required'],
            'payroll' => ['required']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
