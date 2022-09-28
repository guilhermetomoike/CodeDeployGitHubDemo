<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
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
            'nome_completo' => ['sometimes', 'required'],
            'email' => ['sometimes', 'required', 'email'],
            'cpf' => ['sometimes', 'required', 'digits:11'],
            'rg' => ['sometimes', 'required'],
            'pis' => ['sometimes', 'required'],
            'nacionalidade' => ['sometimes', 'required'],
            'naturalidade' => ['sometimes', 'required'],
            'data_nascimento' => ['sometimes', 'required', 'date_format:Y-m-d'],
            'sexo' => ['sometimes', 'required', 'in:M,F'],
            'estado_civil_id' => ['sometimes', 'required', 'integer'],
            'ies_id' => ['sometimes', 'required', 'integer'],
            'qualificacao_id' => ['sometimes', 'required', 'integer'],
            'profissao_id' => ['sometimes', 'required', 'integer'],
            'especialidade_id' => ['sometimes', 'nullable', 'integer'],
        ];
    }
}
