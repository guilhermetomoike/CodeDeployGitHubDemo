<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'slug' => ['required', 'string', 'in:onboard,sale'],
            'name' => ['required', 'string'],
            'question' => ['required', 'string'],
        ];

        if ($this->slug == 'onboard') {
            $rules['min'] = ['required', 'integer', 'between:1,1'];
            $rules['max'] = ['required', 'integer', 'between:5,5'];
        }

        if ($this->slug == 'sale') {
            $rules['min'] = ['required', 'integer', 'between:1,1'];
            $rules['max'] = ['required', 'integer', 'between:10,10'];
        }

        return $rules;
    }
}
