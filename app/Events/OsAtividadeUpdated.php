<?php

namespace App\Events;

use App\Models\OrdemServico\OrdemServicoAtividade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OsAtividadeUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var OrdemServicoAtividade
     */
    private $ordemServicoAtividade;

    /**
     * Create a new event instance.
     *
     * @param OrdemServicoAtividade $ordemServicoAtividade
     */
    public function __construct(OrdemServicoAtividade $ordemServicoAtividade)
    {
        $this->ordemServicoAtividade = $ordemServicoAtividade;
    }

    /**
     * @return OrdemServicoAtividade
     */
    public function getOrdemServicoAtividade(): OrdemServicoAtividade
    {
        return $this->ordemServicoAtividade;
    }
}
