<?php

namespace Modules\EmpresaAlteracao\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaAlteracaoStoreRequest extends FormRequest
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
            'empresa_id' => 'required|integer|exists:empresas,id',
            'solicitacao' => 'required',
        ];
    }
}
