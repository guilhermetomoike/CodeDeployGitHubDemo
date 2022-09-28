<?php

namespace App\Notifications;

use App\Channels\CustomSlack;
use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class EmpresaCadastradaNotification extends Notification implements ShouldQueue
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

    public function toCustomDiscord($notifiable)
    {
        $vendedor = $notifiable->precadastro->usuario;
        $zueira = $this->randomZueira($vendedor->getFirstName());

        if ($notifiable->status_id == 9) {
            $message = "Nova empresa ganha do crm por";
        } else {
            $message = "Nova empresa cadastrada por";
        }

        return DiscordMessage::create()
            ->addChannel(DiscordMedbChannels::COMERCIAL)
            ->addChannel(DiscordMedbChannels::ATENDIMENTO)
            ->setContent("{$message} {$vendedor->getFirstName()}: {$notifiable->id} {$zueira}");
    }

    public function randomZueira($vendedorFirstName)
    {
        switch (rand(0, 50)) {
            case 1:
                $zueira = "\nIsso aí {$vendedorFirstName}, Vamos ficar rico!! :metal:";
                break;
            case 2:
                $zueira = "\nBooooa {$vendedorFirstName}, vai fechar na frente este mês! :scream_cat:";
                break;
            case 3:
                $zueira = "\nTo gostando de ver, {$vendedorFirstName} :upside_down:";
                break;
            case 4:
                $zueira = "\nEsse {$vendedorFirstName} é o melhor!! :ok_hand:";
                break;
            case 5:
                $zueira = "\nVendedor(a) top! :clap:";
                break;
            case 6:
                $zueira = "\nhttps://tenor.com/view/will-smith-ooo-omg-shock-surprise-gif-3607632";
                break;
            case 7:
                $zueira = "\nhttps://tenor.com/view/congrats-sarcasm-congratulations-clapping-clap-gif-14738637";
                break;
            case 8:
                $zueira = ":moneybag:";
                break;
            case 9:
                $zueira = "\nVocê é fera, {$vendedorFirstName} :sunglasses:";
                break;
            default:
                $zueira = null;
        }
        return $zueira;
    }

}
