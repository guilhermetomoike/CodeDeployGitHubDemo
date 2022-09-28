<?php

namespace Modules\Invoice\Console;

use Carbon\Carbon;
use DateTimeImmutable;
use Illuminate\Console\Command;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Jobs\InvoiceGenerateJob;

class GenerateInvoiceCommand extends Command
{
    protected $name = 'financeiro:invoice-generate';

    protected $description = 'Command for generate all recurrent invoices for the month.';

    public function handle()
    {
   
        $date = Carbon::now()->setDay(20)->format('Y-m-d');

        $contasReceber    = ContasReceber
        ::with(['payer'])
        ->whereDate('vencimento', '==', $date)
        ->whereNull('consumed_at')
        ->get()
        ->filter(
            fn ($contaReceber) =>
            $contaReceber->payer  &&
                $contaReceber->valor > 0 &&
                $contaReceber->payer->type != 'atletica' &&
                !$contaReceber->payer->congelada 
                //&& $contaReceber->payer->status_id !== 81
        );



    $contasReceber->each(fn (ContasReceber $contaReceber) => dispatch(
        new InvoiceGenerateJob($contaReceber)
    ));
    }
}
