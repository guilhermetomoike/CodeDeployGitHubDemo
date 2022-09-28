<?php

namespace Modules\Invoice\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Jobs\InvoiceGenerateCartaoJob;

class GenerateInvoiceCartaoCommand extends Command
{
    protected $name = 'financeiro:invoice-cartao-generate';

    protected $description = 'Command for generate all recurrent invoices credit card for the month.';

    public function handle()
    {
   
        $date = Carbon::now()->setDay(20)->format('Y-m-d');

        $contasReceber    = ContasReceber
        ::with(['payer'])
        ->whereDate('vencimento', '<=', $date)
        ->whereNull('consumed_at')

        ->get()
        ->filter(
            fn ($contaReceber) =>
            $contaReceber->payer  &&
                $contaReceber->valor > 0 &&
                $contaReceber->payer->cartao_credito->count() &&
                !$contaReceber->payer->congelada &&
                $contaReceber->payer->status_id !== 81
        );


    $contasReceber->each(fn (ContasReceber $contaReceber) => dispatch(
        new InvoiceGenerateCartaoJob($contaReceber)
    ));
    }
}
