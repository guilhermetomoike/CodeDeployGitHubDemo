<?php


namespace Modules\Invoice\Services\DataTransfer\ChangeInvoiceWebhook;


use Modules\Invoice\Entities\InvoiceStatus;

interface IStatusChangeDataTransfer
{
    public static function FromArray(array $data): self;

    public function getStatus(): InvoiceStatus;

    public function getPaymentMethod(): ?string;

    public function getId(): string;
}
