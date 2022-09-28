<?php

namespace Modules\Irpf\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IrpfAttachmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'qtd_lancamento' => ['required', 'numeric'],
            'ano' => ['required', 'numeric'],
            'declaracao_id' => ['required', 'integer', 'exists:arquivos,id'],
            'recibo_id' => ['required', 'integer', 'exists:arquivos,id'],
            'rural' => ['required', 'boolean'],
            'ganho_captal' => ['required', 'boolean'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
