<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationEntityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'evaluable_type' => ['required','in:cliente,empresa'],
            'evaluable_id' => ['required','integer'],
            'evaluation_id' => ['required','integer', 'exists:evaluations,id'],
            'customer_id' => ['required','integer'],
            'answer' => ['nullable'],
            'observation' => ['nullable'],
        ];

        return $rules;
    }
}
