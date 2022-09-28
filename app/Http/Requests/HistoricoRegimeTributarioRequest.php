<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoricoRegimeTributarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'empresa_id' => ['integer', 'required'],
            'description' => ['string', 'required'],
            'occurred_at' => ['date', 'required'],
            'old_value' => ['string', 'required'],
            'new_value' => ['string', 'required'],
        ];
    }
}
