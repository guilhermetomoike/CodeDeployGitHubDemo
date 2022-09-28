<?php


namespace Modules\Invoice\Services\DataTransfer;


use Doctrine\DBAL\Types\DateImmutableType;

class InvoiceData
{
    /** @var InvoiceItemData[] */
    public array $items;
    public float $subtotal;
    public string $due_date;

    /**
     * @param InvoiceItemData $item
     * @return InvoiceData
     */
    public function setItem(InvoiceItemData $item): InvoiceData
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param float $subtotal
     * @return InvoiceData
     */
    public function setSubtotal(float $subtotal): InvoiceData
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    /**
     * @param string $due_date
     * @return InvoiceData
     */
    public function setDueDate(string $due_date): InvoiceData
    {
        $this->due_date = $due_date;
        return $this;
    }



}
