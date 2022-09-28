<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmCoursesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            '*.id' => ['nullable'],
            '*.cliente_id' => ['required'],
            '*.course_id' => ['nullable'],
            '*.ies_id' => ['required'],
            '*.initial_date' => ['nullable'],
            '*.conclusion_date' => ['nullable'],
        ];

        return $rules;
    }
}
