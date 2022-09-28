<?php

namespace Modules\Apontamentos\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApontamentosRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nome' => ['required', 'string'],
            'sla' => ['required', 'integer']
        ];
    }

    public function authorize()
    {
        return true;
    }
}
