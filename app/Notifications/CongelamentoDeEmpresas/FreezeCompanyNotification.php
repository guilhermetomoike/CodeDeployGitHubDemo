<?php

namespace App\Notifications\CongelamentoDeEmpresas;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FreezeCompanyNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage::create()
            ->setUsername('Congelamento de Empresa')
            ->setContent("@everyone A Empresa {$notifiable->id} Foi Congelada.")
            ->addChannel(DiscordMedbChannels::CONTABILIDADE);
    }
}
