<?php

namespace Modules\Plans\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer_type' => ['required', 'string', 'in:cliente,empresa'],
            'payer_id' => ['required', 'numeric', Rule::exists(request('payer_type') . 's', 'id')],
            'plans' => ['required', 'array', 'min:1'],
            'plans.*.plan_id' => [
                'required',
                'numeric',
                'exists:plans,id'
            ]
        ];
    }

    public function messages()
    {
        return [
            'payer_type.required' => 'Informe o tipo do pagador pagador (Empresa ou cliente)',
            'payer_type.in' => 'Os tipos de pagadores aceitos precisam ser \'Cliente\' ou \'Empresa\'',
            'payer_type.string' => 'Informe um pagador (Empresa ou cliente)',

            'payer_id.numeric' => 'Informe o numero de uma empresa ou cliente',
            'payer_id.exists' => 'O pagador informado nao existe',
            'payer_id.required' => 'Informe o numero do pagador',

            'plans.required' => 'Selecione pelo menos 1 plano.',
            'plans.min' => 'Selecione pelo menos 1 plano.',
            'plans.array' => 'Os planos precisam ser uma Matriz.',

            'plans.*.plan_id.required' => 'Selecione pelo menos 1 plano.',
            'plans.*.plan_id.numeric' => 'É preciso ser enviado o ID do plano na requisição.',
            'plans.*.plan_id.exists' => 'O Plano informado nao existe',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
