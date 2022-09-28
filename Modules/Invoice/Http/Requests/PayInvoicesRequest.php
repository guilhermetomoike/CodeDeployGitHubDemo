<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayInvoicesRequest extends FormRequest
{
    public function rules()
    {
        return [
            'invoices' => ['array', 'min:1'],
            'credit_card_id' => ['required', 'exists:cartao_credito,id'],
        ];
    }

    public function messages()
    {
        return [
            'invoices.array' => 'É preciso informar pelomenos uma fatura',
            'invoices.min' => 'É preciso informar pelomenos uma fatura',
            'credit_card_id.required' => 'Forma de pagamento inválida.',
            'credit_card_id.in' => 'Forma de pagamento inválida.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
