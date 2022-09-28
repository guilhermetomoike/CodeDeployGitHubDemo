<?php

namespace Modules\Invoice\Services\Webhook;

use Modules\Invoice\Entities\Fatura;
use Modules\Invoice\Entities\InvoiceStatus;
use Modules\Invoice\Services\DataTransfer\ChangeInvoiceWebhook\IStatusChangeDataTransfer;

class ChangeInvoiceStatus implements IChangeInvoiceStatus
{

    public function execute(IStatusChangeDataTransfer $data)
    {
        $fatura = Fatura::query()
            ->firstWhere('gatway_fatura_id', $data->getId());

        if (!$fatura) return false;

        $fatura->status = $data->getStatus()->valueType();

        if ($data->getStatus()->is('paid') || $data->getStatus()->is('partially_paid')) {
            $fatura->data_recebimento = today();
        }

        if ($data->getPaymentMethod() === 'iugu_bank_slip') {
            $fatura->forma_pagamento_id = 1;
        } else if ($data->getPaymentMethod() === 'iugu_credit_card') {
            $fatura->forma_pagamento_id = 2;
        } else {
            $fatura->forma_pagamento_id = 3;
        }

        $fatura->save();

        return $fatura;
    }
}
