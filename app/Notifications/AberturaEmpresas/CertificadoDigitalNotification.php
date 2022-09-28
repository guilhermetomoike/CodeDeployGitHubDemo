<?php

namespace App\Notifications\AberturaEmpresas;

use App\Channels\CustomSlack;
use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class CertificadoDigitalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage::create()
            ->setUsername('Abridor de Empresa')
            ->setContent("A empresa {$notifiable->id} concluiu a etapa de E-CPF.")
            ->addChannel(DiscordMedbChannels::ATENDIMENTO);
    }
}
