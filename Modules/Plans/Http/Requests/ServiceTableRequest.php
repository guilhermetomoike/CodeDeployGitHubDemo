<?php

namespace Modules\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceTableRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:6|max:250',
            'description' => 'required|string|min:10|max:250',
            'price' => 'required|numeric',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
