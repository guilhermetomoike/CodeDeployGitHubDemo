<?php


namespace Modules\Invoice\Services\SendInvoice;


interface ISendPendingInvoices
{
    public function execute(array $data);
}
