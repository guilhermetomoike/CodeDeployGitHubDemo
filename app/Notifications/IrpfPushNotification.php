<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class IrpfPushNotification extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }

    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->setSubject("Existem pendências para sua análise de IRPF.")
            ->setData('type', 'irpf')
            ->setBody("Envie os documentos/comprovantes que faltam até o prazo, e não caia na malha fina!");
    }
}
