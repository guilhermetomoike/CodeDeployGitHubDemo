<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cliente_id' => ['required_if:empresa_id,null', 'numeric', 'exists:clientes,id'],
            'empresa_id' => ['nullable', 'numeric'],
            'token_cartao' => ['required', 'string', 'min:15', 'max:150']
        ];
    }

    public function messages()
    {
        return [
            'cliente_id' => 'ID de cliente inválido ou não informado.',
            'empresa_id' => 'ID de empresa inválido ou não informado.',
            'token_cartao' => 'Token de cartão de crédito inválido'
        ];
    }

    public function authorize()
    {
        return true;
    }
}
