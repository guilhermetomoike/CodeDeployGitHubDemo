<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteCourseRequest extends FormRequest
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
            'cliente_id' => 'required',
            'ies_id' => 'required',
            'course_id' => 'nullable',
            'initial_date' => 'nullable',
            'conclusion_date' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'O cliente é obrigatório',
            'ies_id.required' => 'O IES é obrigatório',
        ];
    }
}
