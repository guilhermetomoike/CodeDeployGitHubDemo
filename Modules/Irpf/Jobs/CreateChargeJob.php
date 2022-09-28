<?php

namespace Modules\Irpf\Jobs;

use App\Models\Cliente;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Notifications\ChargeIrpfNotification;
use Modules\Irpf\Services\Contracts\CalculateChargesInterface;
use Modules\Irpf\Services\Contracts\CreateChargeInterface;
use Modules\Irpf\Services\SendEmailDeclaracaoService;

class CreateChargeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 1;
    public DeclaracaoIrpf $declaracaoIrpf;

    public function __construct(DeclaracaoIrpf $declaracaoIrpf)
    {
        $this->declaracaoIrpf = $declaracaoIrpf;
        $this->onQueue('financeiro');
    }

    public function tags()
    {
        return ['declaracao_irpf', 'cliente_id:' . $this->declaracaoIrpf->cliente_id];
    }

    public function handle(CalculateChargesInterface $calculateCharges, CreateChargeInterface $CreateChargeService)
    {
        call_user_func(new SendEmailDeclaracaoService($this->declaracaoIrpf));
        return;

        // implementacao para liberação dos demais sem cobrança

        $cliente = $this->declaracaoIrpf->cliente;

        $calculateCharges->setDeclaracaoIrpf($this->declaracaoIrpf);
        $chargesArray = $calculateCharges->execute();

        if (!count($chargesArray) || $cliente->empresa->contains('id', '<', 610)) {
            call_user_func(new SendEmailDeclaracaoService($this->declaracaoIrpf));
            return;
        }

        $fatura = $CreateChargeService->createCharge($chargesArray, $cliente);
        // desabilitado a pedido do Tiago por um erro que estava dando no IRPF
        //$cliente->notify(new ChargeIrpfNotification($fatura));
    }
}
