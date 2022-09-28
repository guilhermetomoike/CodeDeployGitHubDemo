<?php

namespace App\Jobs;

use App\Models\Empresa;
use App\Services\Recebimento\Gatway\Iugu\IuguService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateIuguPaymentMethodJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $empresa_id;

    public function __construct(int $empresa_id)
    {
        $this->empresa_id = $empresa_id;
    }

    public function handle(IuguService $iuguService)
    {
        $empresa = Empresa::find($this->empresa_id);
        $iuguService->criarFormaPagamento($empresa);
    }
}
