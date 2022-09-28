<?php

namespace App\Http\Requests;

use App\Rules\Base64PDF;
use Illuminate\Foundation\Http\FormRequest;

class UploadReceitasRequest extends FormRequest
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
            'receitas' => 'required',
            'receitas.*.name' => 'required',
            'receitas.*.base64' => [new Base64PDF()],
            'receitas.*.competencia' => 'required|date_format:Y-m-d',
        ];
    }
}
