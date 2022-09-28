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

class NfseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordWebookChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->cc('onboarding@medb.com.br')
            ->replyTo('onboarding@medb.com.br')
            ->subject('Sua empresa está pronta!')
            ->greeting('Parabéns! Sua empresa está pronta e agora você pode faturar!')
            ->line('Chegamos ao final do processo de abertura de sua empresa. A partir de agora você será
            direcionado para a equipe de contadores da Medb.')
            ->line('A nossa equipe de contadores estará disponível para tirar qualquer dúvida que você tenha em
            relação a tributação ou demais orientações relacionadas à sua empresa.')
            ->line('A Medb proporciona a você uma experiência de comunidade, onde você tem acesso as melhores
             ferramentas, profissionais e oportunidades. Nosso objetivo é fazer da sua carreira médica rentável,
             facilitando a gestão do seu tempo e dinheiro.');
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage::create()
            ->setUsername('Abridor de Empresa')
            ->setContent("A empresa {$notifiable->id} concluiu a etapa de NFSE.")
            ->addChannel(DiscordMedbChannels::ATENDIMENTO);
    }
}
