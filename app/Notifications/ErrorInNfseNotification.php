<?php

namespace App\Notifications;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ErrorInNfseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage
            ::create()
            ->addChannel(DiscordMedbChannels::FINANCEIRO)
            ->setContent("Erro ao emitir NFSE para a empresa {$notifiable->id}.\nErro: {$this->message}");
    }

}
