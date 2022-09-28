<?php

namespace Modules\Irpf\Notifications;

use App\Models\Fatura;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChargeIrpfNotification extends Notification
{
    use Queueable;

    private Fatura $fatura;

    public function __construct(Fatura $fatura)
    {
        $this->fatura = $fatura;
    }

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
            ->line('Estamos enviando boleto referente a elaboração do Imposto de Renda Pessoa Física 2019-2020.')
            ->line('O envio da Declaração e Recibo, será automático.')
            ->line('Após o pagamento da fatura por boleto ou por cartão de credito, você receberá a Declaração em até 24 horas.')
            ->line('Os valores foram estipulados da seguinte forma:')
            ->line('Até 05 registros, R$ 150,00')
            ->line('Acima de 05 registros, valor adicional de R$ 10,00')
            ->line('Ganho de Capital; R$ 150,00')
            ->line('Rural: 150,00')
            ->action('Pagar', $this->fatura->fatura_url);
    }

}
