<?php

namespace Modules\Invoice\Services\SendInvoice;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Modules\Invoice\Emails\SendInvoicesPendingMail;
use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Services\PaymentAdapter\RenewInvoiceAdapter;

class SendPendingInvoices implements ISendPendingInvoices
{
    private RenewInvoiceAdapter $renewInvoiceService;

    public function __construct(RenewInvoiceAdapter $updateInvoice)
    {
        $this->renewInvoiceService = $updateInvoice;
    }

    public function execute(array $data)
    {
        $payer_data = Arr::only($data, ['payer_id', 'payer_type']);
        $invoices_id = $data['invoices'];

        $faturas = Fatura::query()
            ->where($payer_data)
            ->whereIn('id', $invoices_id)
            ->get();

        $faturas = $faturas->map(fn(Fatura $fatura) => $this->renewInvoice($fatura));

        Mail::send(new SendInvoicesPendingMail($faturas, $this->choosesEmail($data)));
    }

    private function renewInvoice(Fatura $fatura): Fatura
    {
        if ($fatura->data_vencimento->format('Y-m-d') >= today()->format('Y-m-d')) {
            return $fatura;
        }
        return $this->renewInvoiceService->execute($fatura);
    }

    private function choosesEmail(array $data): string
    {
        if (isset($data['email']) && !empty($data['email'])) {
            return $data['email'];
        }

        $payerModel = Relation::getMorphedModel($data['payer_type']);
        $payer = $payerModel::find($data['payer_id']);

        if (!$emails = $payer->contatos()->email()) {
            throw new \InvalidArgumentException('Nenhum email cadastrado ou informado.', 422);
        }

        return $emails->first();
    }
}
