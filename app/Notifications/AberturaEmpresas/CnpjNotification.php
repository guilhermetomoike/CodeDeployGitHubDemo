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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class CnpjNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', DiscordWebookChannel::class];
    }

    public function toMail($notifiable)
    {
        $cnpj = mask($notifiable->cnpj, '##.###.###/####-##');

        $arquivos = $notifiable
            ->arquivos()
            ->whereIn('nome', ['cartao_cnpj', 'contrato_social'])
            ->get();

        return (new MailMessage)
            ->attachData(Storage::disk('s3')->get($arquivos[0]->caminho), $arquivos[0]->nome)
            ->attachData(Storage::disk('s3')->get($arquivos[1]->caminho), $arquivos[1]->nome)
            ->cc('onboarding@medb.com.br')
            ->replyTo('onboarding@medb.com.br')
            ->subject('Abertura de empresa - CNPJ')
            ->greeting("Olá, como você está?")
            ->line('Tenho uma ótima notícia, seu CNPJ está pronto!')
            ->line('O processo de abertura de sua empresa está avançando e estamos muito felizes por você.')
            ->line('Nesta etapa, iremos tratar da liberação do Alvará de Funcionamento da empresa. O que isso quer dizer?
                    Ainda que sua empresa já possua CNPJ, será necessária a emissão do Alvará e liberação de emissão de
                    Nota Fiscal. Para estas atividades de licenciamento, também se fará necessário o pagamento de taxas.')
            ->line("Aqui também orientamos que você faça a abertura da conta corrente bancária da sua empresa.")
            ->salutation('Até o próximo contato!');
    }

    public function toCustomDiscord($notifiable)
    {
        return DiscordMessage::create()
            ->setUsername('Abridor de Empresa')
            ->setContent("A Empresa {$notifiable->id} concluiu a etapa de CNPJ. Estado: {$notifiable->endereco->uf}")
            ->addChannel(DiscordMedbChannels::ATENDIMENTO)
            ->addChannel(DiscordMedbChannels::ABERTURA);
    }

}
