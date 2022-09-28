<?php

namespace App\Events;

use App\Models\Empresa;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmpresaCadastradaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $empresa;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function getEmpresa(): Empresa
    {
        return $this->empresa;
    }
}
