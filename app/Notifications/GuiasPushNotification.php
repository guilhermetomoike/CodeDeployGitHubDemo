<?php

namespace App\Notifications;

use App\Models\Empresa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class GuiasPushNotification extends Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue;

    private Empresa $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function via($notifiable)
    {
        return [OneSignalChannel::class];
    }

    public function toOneSignal($notifiable)
    {
        if ($this->empresa->carteiras()->firstWhere('setor', 'contabilidade')->id != 2) {
            $this->delete();
            return;
        }

        return OneSignalMessage::create()
            ->setSubject("Guias de impostos disponíveis!")
            ->setData('type', 'guide')
            ->setBody("A guias de impostos da empresa {$this->empresa->razao_social} já estão disponíveis para pagamento.");
    }
}
