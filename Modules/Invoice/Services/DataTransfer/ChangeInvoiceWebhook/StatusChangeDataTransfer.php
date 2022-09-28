<?php


namespace Modules\Invoice\Services\DataTransfer\ChangeInvoiceWebhook;


use Modules\Invoice\Entities\InvoiceStatus;

class StatusChangeDataTransfer implements IStatusChangeDataTransfer
{
    private string $id;
    private InvoiceStatus $status;
    private ?string $payment_method;

    public function __construct(string $id, string $status, ?string $payment_method)
    {
        $this->id = $id;
        $this->status = new InvoiceStatus($status);
        $this->payment_method = $payment_method;
    }

    public static function FromArray(array $data): self
    {
        return new StatusChangeDataTransfer(
            $data['data']['id'],
            $data['data']['status'],
            $data['data']['payment_method']
        );
    }

    public function getStatus(): InvoiceStatus
    {
        return $this->status;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
