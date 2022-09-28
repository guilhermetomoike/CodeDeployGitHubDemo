<?php

namespace App\Observers;

use App\Jobs\EmitirNfseJob;
use Modules\Invoice\Entities\Fatura;

class FaturaObserver
{
    public function creating(Fatura $fatura)
    {
        if (!$fatura->formama_pagamento_id) $fatura->forma_pagamento_id = 1;
    }

    public function updated(Fatura $fatura)
    {
        if ($fatura->wasChanged('status') && $fatura->status === 'pago') {
            // EmitirNfseJob::dispatch($fatura);
        }
    }
}
