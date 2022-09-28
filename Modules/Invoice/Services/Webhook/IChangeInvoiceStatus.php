<?php


namespace Modules\Invoice\Services\Webhook;


use Modules\Invoice\Services\DataTransfer\ChangeInvoiceWebhook\IStatusChangeDataTransfer;

interface IChangeInvoiceStatus
{
    public function execute(IStatusChangeDataTransfer $data);
}
