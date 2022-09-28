<?php


namespace Modules\Invoice\Services\DataTransfer;


use Modules\Plans\Entities\Plan;

class InvoiceItemData
{
    public string $description;
    public float $price;

    /**
     * InvoiceItemData constructor.
     * @param string $description
     * @param float $price
     */
    public function __construct(string $description, float $price)
    {
        $this->description = $description;
        $this->price = $price;
    }
}
