<?php

namespace App\Listeners;

use App\Channels\Discord\DiscordMedbChannels;
use App\Channels\Discord\DiscordMessage;
use App\Channels\Discord\DiscordWebookChannel;
use App\Events\OsAtividadeUpdated;
use App\Notifications\OrdemServicoFinalizadaNotification;
use App\Services\SlackService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OsAtividadeFinalizadaListener implements ShouldQueue
{
    use Queueable;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->onQueue('default');
    }

    /**
     * Handle the event.
     *
     * @param OsAtividadeUpdated $event
     * @return void
     */
    public function handle(OsAtividadeUpdated $event)
    {
        $osAtividade = $event->getOrdemServicoAtividade();
        $osItem = $osAtividade->ordem_servico_item;
        $empresa = $osItem->ordem_servico->empresa;
        $cliente = $osItem->ordem_servico->cliente;
        $qtd_atividades = $osItem->atividades->count();
        $qtd_atividades_finalizadas = $osItem->atividades()->where('status', 'concluido')->count();

        if ($qtd_atividades == $qtd_atividades_finalizadas) {
            return;
        }

        if ($cliente) {
            $cliente->notify(new OrdemServicoFinalizadaNotification);
        }

        $internalMessage = DiscordMessage::create()
            ->addChannel(DiscordMedbChannels::CONTABILIDADE)
            ->setContent('Ordem de serviço finalizada da empresa ' . $empresa->id);
        DiscordWebookChannel::staticSend($internalMessage);

    }
}
