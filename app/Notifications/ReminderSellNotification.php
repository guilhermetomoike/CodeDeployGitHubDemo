<?php

namespace App\Notifications;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReminderSellNotification extends Notification
{
    use Queueable;

    private string $type;

    public function __construct(string $type = 'warn')
    {
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toCustomDiscord($notifiable)
    {
        $vendedor = $notifiable->precadastro->usuario->getFirstName();
        $message = DiscordMessage::create()->addChannel(DiscordMedbChannels::COMERCIAL);
        if ($this->type === 'warn') {
            $message->setContent("{$vendedor}, Se o cliente da Empresa {$notifiable->id} não assinar o contrato vamos ter que canelar a venda. :cry:");
        } else {
            $message->setContent("{$vendedor}, o cliente da Empresa {$notifiable->id} não assinou e tive que cancelar. :sob:");
        }

        return $message;
    }
}
