<?php

namespace Modules\Invoice\Console;

use Illuminate\Console\Command;
use Modules\Invoice\Repositories\InvoiceRepository;

class DeleteCanceledInvoicesCommand extends Command
{
    protected $name = 'clean:invoice';

    protected $description = 'Remove todas as faturas canceladas a mais de 15 dias.';

    public function handle(InvoiceRepository $invoiceRepository)
    {
        $maxDateForDeleteCanceledInvoices = today()->subDays(15)->toDateString();
        $invoiceRepository->deleteInvoiceCanceledBeforeThat($maxDateForDeleteCanceledInvoices);
    }
}
