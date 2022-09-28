<?php

namespace App\Notifications\Whatsapp;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WhatsappChannel;
use App\Models\NotifiableContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GuiaDisponivelWhatsApp extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 1;

    /**
     * GuiaDisponivelWhatsApp constructor.
     */
    public function __construct()
    {
        $this->onQueue('twilio');
    }

    public function attempts()
    {
        return 1;
    }

    public function tags()
    {
        return ['guias_liberadas_whatsapp'];
    }

    public function via($notifiable)
    {
        return [WhatsappChannel::class];
    }

    public function toWhatsapp(NotifiableContract $notifiable)
    {
        $guaiLiberacao = $notifiable->guia_liberacao()->firstWhere('competencia', competencia_anterior());
        $guias = $guaiLiberacao->guias()
            ->where('data_competencia', $guaiLiberacao->competencia)
            ->with('arquivo')
            ->get();

        if ($guias->count() === 0) {
            exit;
        }

        $msg = "Olá! Tudo bem?\nSuas guias de impostos e o boleto dos honorários da empresa \"{$notifiable->razao_social}\" já estão disponíveis esse mês. Se preferir, posso te encaminhar por aqui as guias. Se quiser receber agora, só me enviei “GUIAS” e chegará até você! \nCaso já tenha realizado o pagamento, desconsiderar essa mensagem!";
        $numero = $notifiable->routeNotificationForWhatsApp();
        abort_if(!$numero, '422', 'Nenhum numero de whatsapp cadastrado para notificação');

        return WhatsAppMessage::create()
            ->setRecipient($numero[0])
            ->setMessage($msg);
    }
}
