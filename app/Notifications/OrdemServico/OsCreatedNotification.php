<?php

namespace App\Notifications\OrdemServico;

use App\Channels\CustomSlack;
use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use App\Models\Empresa;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OsCreatedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        $carteiras = Empresa::find($notifiable->id)->carteiras->pluck('nome');

        $message = DiscordMessage::create()
            ->setContent('@everyone Nova ordem de serviço para empresa ' . $notifiable->id . ' - ' . $notifiable->razao_social);

        if (in_array("Contabil 1", $carteiras->toArray())) {
            $message->addChannel(DiscordMedbChannels::CELULA_1);
        }

        if (in_array("Contábil 2", $carteiras->toArray())) {
            $message->addChannel(DiscordMedbChannels::CELULA_2);
        }

        if (in_array("Contabil 3", $carteiras->toArray())) {
            $message->addChannel(DiscordMedbChannels::CELULA_3);
        }

        if (in_array("Contabil 4", $carteiras->toArray())) {
            $message->addChannel(DiscordMedbChannels::CELULA_4);
        }

        return $message;
    }

}
