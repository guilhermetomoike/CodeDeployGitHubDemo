<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class GetFaturamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!request()->empresa_id) {
            return true;
        }

        if (request()->cliente_id) {
            $cliente = Cliente::find(request()->cliente_id);
        } else {
            $cliente = auth('api_clientes')->user();
        }

        $empresa_socios_ids = Empresa::getSociosId(request()->empresa_id);

        if ($cliente && !in_array($cliente->id, $empresa_socios_ids)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'empresa_id' => 'required',
            'email' => ['required_if:enviarEmail,true', 'email'],
        ];

        if (Str::contains(request()->requestUri, 'renda') &&
            !is_a(auth('api_clientes')->user(), Cliente::class)) {
            $rule['cliente_id'] = 'required';
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'empresa_id.required' => 'Você precisa informar uma empresa.',
            'cliente_id.required' => 'Você precisa informar um cliente.',
            'email.required' => 'Informe um email para o envio.',
            'email.email' => 'Informe um email válido.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
//        parent::failedValidation($validator);
        throw new BadRequestHttpException($validator->errors()->first());
    }

    protected function failedAuthorization()
    {
//        throw new \Exception('Você não tem autorização para realizar esta ação.');
        throw new AuthorizationException('Você não tem autorização para realizar esta ação.');
    }
}
