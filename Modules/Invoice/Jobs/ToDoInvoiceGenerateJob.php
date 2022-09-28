<?php

namespace Modules\Invoice\Jobs;

use App\Models\Cliente;
use App\Models\Payer\PayerContract;
use Modules\Invoice\Services\ICreateInvoice;
use Modules\Invoice\Services\DataTransfer\InvoiceData;
use Modules\Invoice\Services\DataTransfer\InvoiceItemData;
use Modules\Invoice\Services\FaturaService;
use App\Services\GuiaService;
use App\Services\Recebimento\RecebimentoService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ToDoInvoiceGenerateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private PayerContract $payer;

    public function __construct(PayerContract $payer)
    {
        $this->onQueue('financeiro');
        $this->payer = $payer;
    }

    public function tags()
    {
        return [$this->payer->getModelAlias() . ':' . $this->payer->id];
    }

    public function handle(ICreateInvoice $createInvoice)
    {
        $plans = $this->payer->plans()->get();
        $invoiceObject = new InvoiceData();
        $invoiceObject->setSubtotal($plans->sum('price'));
        $invoiceObject->setDueDate(config('invoice.default_due_date'));
        foreach ($plans as $plan) {
            $invoiceObject->setItem(new InvoiceItemData($plan->name, $plan->price));
        }

        $createInvoice->execute($invoiceObject);
    }
}
