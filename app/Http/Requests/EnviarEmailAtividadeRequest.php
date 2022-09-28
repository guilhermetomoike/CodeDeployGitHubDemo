<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnviarEmailAtividadeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'os_item_id' => 'required',
            'emails'   => 'required|array|min:2',
            'emails.cliente' => 'required|email',
            'emails.usuario' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'os_item_id.required' => 'Você deve informar a tarefa para o envio de e-mail.',
            'emails.required' => 'Você deve informar os e-mails para notificar a finalização dos e-mails.',
            'emails.min' => 'Você deve informar pelo menos dois e-mails para enviar a notificação.',
            'emails.cliente' => 'Você deve informar o e-mail do cliente para qual deve ser enviado o e-mail.',
            'emails.usuario' => 'Você deve informar o e-mail do usuario para qual deve ser enviado o e-mail..'
        ];
    }
}
