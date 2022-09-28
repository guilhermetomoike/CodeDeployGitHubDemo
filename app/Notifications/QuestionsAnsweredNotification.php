<?php

namespace App\Notifications;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionsAnsweredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default');
    }

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class, 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->replyTo('gestaomedb@gmail.com')
            ->cc('gestaomedb@gmail.com')
            ->subject('Sua Declaração de IRPF')
            ->line('Finalizamos a sua análise IRPF e verificamos que a sua declaração é OBRIGATÓRIA.')
            ->line('Fale com seu gestor para já iniciarmos sua declaração.')
            ->line('Mais uma vez agradecemos a sua confiança. ');
    }

    public function toCustomDiscord($customer)
    {
        $company = "{$customer->empresa[0]->id} - " ?? '';
        $message = "@everyone Cliente {$company}{$customer->nome_completo} respondeu o Questionário do IRPF.";
        $notification = DiscordMessage::create();
        $channels = $this->getChannels($customer);

        foreach ($channels as $channel) {
            $notification->addChannel($channel);
        }

        return $notification->setContent($message);
    }

    private function getChannels($customer)
    {
        if (!$customer->empresa) return [DiscordMedbChannels::SEM_CARTEIRA];

        $channels = [];
        foreach ($customer->empresa as $empresa) {
            if (!$empresa->carteiras) return [DiscordMedbChannels::SEM_CARTEIRA];

            foreach ($empresa->carteiras as $carteira) {
                $channel = $this->getChannelByCarteira($carteira->id);

                if ($channel) {
                    $channels[] = $channel;
                }
            }
        }

        if (count($channels) === 0) return [DiscordMedbChannels::SEM_CARTEIRA];

        return $channels;
    }

    private function getChannelByCarteira($carteiraId)
    {
        $channels = [
            1 => DiscordMedbChannels::CELULA_1,
            2 => DiscordMedbChannels::CELULA_2,
            3 => DiscordMedbChannels::CELULA_3,
            4 => DiscordMedbChannels::CELULA_4,
            7 => DiscordMedbChannels::CELULA_5,

            
        ];

        return $channels[$carteiraId] ?? null;
    }
}
