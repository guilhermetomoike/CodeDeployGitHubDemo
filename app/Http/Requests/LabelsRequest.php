<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'labelable_type' => ['nullable', 'in:empresa'],
            'labelable_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:1,2,3'],
            'note' => ['nullable', 'string']
        ];
    }
}
