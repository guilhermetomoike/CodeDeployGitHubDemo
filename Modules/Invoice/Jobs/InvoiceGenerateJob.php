<?php

namespace Modules\Invoice\Jobs;

use Modules\Invoice\Entities\ContasReceber;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Invoice\Services\CreateInvoiceService;
use Modules\Invoice\Services\CreateInvoiceServiceAsas;

class InvoiceGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ContasReceber $contaReceber;

    public function __construct(ContasReceber $contasReceber)
    {
        $this->onQueue('financeiro');
        $this->contaReceber = $contasReceber;
    }

    public function tags()
    {
        return [$this->contaReceber->payer->getModelAlias() . ':' . $this->contaReceber->payer->id];
    }

    public function handle(CreateInvoiceServiceAsas $createInvoiceService)
    {
        $createInvoiceService->execute($this->contaReceber);
        sleep(0.7);
    }
}
