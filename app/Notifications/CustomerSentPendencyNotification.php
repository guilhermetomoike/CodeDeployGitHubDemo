<?php

namespace App\Notifications;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CustomerSentPendencyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default');
    }

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($customer)
    {
        $company = "{$customer->empresa[0]->id} - " ?? '';
        $message = "@everyone Cliente {$company}{$customer->nome_completo} enviou todas as pendências do IRPF.";
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
            7 => DiscordMedbChannels::CELULA_4,
        ];

        return $channels[$carteiraId] ?? null;
    }
}
