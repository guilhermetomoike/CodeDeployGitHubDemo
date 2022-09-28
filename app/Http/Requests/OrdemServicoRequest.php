<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdemServicoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'empresa_id' => 'required_if:cliente_id,null',
            'cliente_id' => 'required_if:empresa_id,null',
            'os_base' => 'array|min:1',
            'os_base.*.os_base_id' => 'required',
            'os_base.*.data_limite' => 'required|date_format:Y-m-d|after_or_equal:today',
            'os_base.*.competencia' => 'nullable|date_format:Y-m-d',
            'anexos.*' => 'nullable|file|mimes:jpeg,bmp,png,pdf,txt,jpg,doc,docx,xls,xlsx'
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'Você deve informar a empresa solicitante pela ordem de serviço.',
            'descricao.required' => 'Você deve informar uma descrição para ordem de serviço.',
            'usuario_id.required' => 'Você deve informar o o responsável pela ordem de serviço.',
            'os_base.required' => 'Você deve inserir pelo menos um serviço para está ordem de serviço.',
            'os_base.min' => 'Você deve inserir pelo menos um serviço para está ordem de serviço.'
        ];
    }
}
