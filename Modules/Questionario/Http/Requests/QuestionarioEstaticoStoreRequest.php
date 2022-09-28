<?php

namespace Modules\Questionario\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionarioEstaticoStoreRequest extends FormRequest
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
            'customer_id' => ['required', 'integer', 'exists:clientes,id'],
            'etapa_carreira' => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'etapa_carreira_especialidade' => ['string', 'max:256'],
            'etapa_carreira_instituicao' => ['string', 'max:256'],
            'graduacao_instituicao_tipo' => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'graduacao_instituicao_nome' => ['required', 'string', 'max:256'],
            'graduacao_conclusao_ano' => ['required', 'integer', 'gt:0'],
            'financiamento_estudantil' => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'financiamento_estudantil_outro' => ['string', 'max:256'],
            "local_atendimento"    => ['required', 'array', 'min:1'],
            "local_atendimento.*"  => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'local_atendimento_outro' => ['string', 'max:256'],
            'faturamento_mensal' => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'faturamento_mensal_sonho' => ['required', 'numeric'],
            "contrato_recebimento"    => ['required', 'array', 'min:1'],
            "contrato_recebimento.*"  => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            "fonte_alternativa"    => ['required', 'array', 'min:1'],
            "fonte_alternativa.*"  => ['required', 'integer', 'exists:questionario_pergunta_escolhas,id'],
            'fonte_alternativa_outro' => ['string', 'max:256'],
            'horas_semanal_trabalhada' => ['required', 'integer', 'gt:0'],
            'horas_pretendida_trabalhada' => ['required', 'integer', 'gt:0'],
            'objetivos_futuros' => ['required', 'string'],
        ];
    }
}
