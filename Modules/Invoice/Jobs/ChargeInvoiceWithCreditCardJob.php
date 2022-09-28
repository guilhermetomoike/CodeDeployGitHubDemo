<?php

namespace Modules\Invoice\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Services\PaymentAdapter\ChargeInvoiceAdapter;

class ChargeInvoiceWithCreditCardJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Fatura $fatura;

    public function __construct(Fatura $fatura)
    {
        $this->onQueue('financeiro');
        $this->fatura = $fatura;
    }

    public function handle(ChargeInvoiceAdapter $chargeInvoiceService)
    {
        if ($this->attempts() > 1) {
            return;
        }
        $chargeInvoiceService->execute($this->fatura);
        sleep(1);
    }
}
