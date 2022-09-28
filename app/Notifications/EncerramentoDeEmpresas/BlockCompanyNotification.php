<?php

namespace App\Notifications\EncerramentoDeEmpresas;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlockCompanyNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage::create()
            ->setUsername('Encerramento de Empresa')
            ->setContent("@everyone A Empresa {$notifiable->id} Foi Encerrado.")
            ->addChannel(DiscordMedbChannels::CONTABILIDADE);
    }
}
