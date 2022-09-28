<?php

namespace Modules\Invoice\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceRequest extends FormRequest
{

    public function rules()
    {
        return [
            'data_vencimento' => ['required', 'date'],
            'data_competencia' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.valor' => ['required', 'numeric'],
            'items.*.descricao' => ['required'],
            'payer_id' => ['required', 'integer'],
            'payer_type' => ['required', 'in:cliente,empresa'],
            'tipo_cobrancas_id' => ['required', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
