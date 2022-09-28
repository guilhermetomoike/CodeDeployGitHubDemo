<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendInvoicesRequest extends FormRequest
{

    public function rules()
    {
        return [
            'payer_type' => ['required', 'string', 'in:cliente,empresa'],
            'payer_id' => ['required', 'numeric'],
            'invoices' => ['array', 'min:1'],
            'email' => ['nullable', 'email'],
        ];
    }

    public function messages()
    {
        return [
            'payer_type.required' => 'Tipo de cliente não informado.',
            'payer_type.string' => 'Tipo de cliente informado é inválido.',
            'payer_type.in' => 'Informe se é uma pessoa física ou jurídica.',
            'payer_id.required' => 'Informe o numero do cliente/empresa',
            'payer_id.numeric' => 'Informe um número de cliente/empresa',
            'invoices.array' => 'É preciso informar pelomenos uma fatura',
            'invoices.min' => 'É preciso informar pelomenos uma fatura',
            'email.email' => 'Informe um email válido',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
