<?php

namespace Modules\Irpf\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NaoAceiteIrpfNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->replyTo('gestaomedb@gmail.com')
            ->cc('gestaomedb@gmail.com')
            ->subject('Sua Declaração de IRPF')
            ->line('Você optou por não fazer o imposto de renda conosco.')
            ->line('Agradecemos sua confirmação e nos colocamos à disposição para declarações futuras.');
    }

}
