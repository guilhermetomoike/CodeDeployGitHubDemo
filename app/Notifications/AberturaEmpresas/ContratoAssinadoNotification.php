<?php

namespace App\Notifications\AberturaEmpresas;

use App\Channels\CustomSlack;
use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class ContratoAssinadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        $vendedor = $notifiable->precadastro->usuario;
        return DiscordMessage::create()
            ->setUsername('Abridor de Empresa')
            ->setContent("A Empresa {$notifiable->id} assinou o contrato. Vendedor: {$vendedor->getFirstName()}")
            ->addChannel(DiscordMedbChannels::COMERCIAL)
            ->addChannel(DiscordMedbChannels::ATENDIMENTO);
    }

}
