<?php


namespace App\Services\Recebimento\Gatway\Iugu\Common;


class PaymentSubItem
{
    public $description;
    public $price_cents;
    public $quantity = 1;
    public $recurrent = false;

    /**
     * PaymentSubItem constructor.
     * @param null $item
     */
    public function __construct($item = null)
    {
        if ($item) {
            $this->build($item);
        }
    }

    private function build($item)
    {
        $this->setQuantity($item->qtd ?? 1)
            ->setDescription($item->descricao ?? '')
            ->setPriceCents($item->preco)
            ->setRecurrent(true);
    }

    /**
     * @param mixed $description
     * @return PaymentSubItem
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $price_cents
     * @return PaymentSubItem
     */
    public function setPriceCents($price_cents)
    {
        $this->price_cents = (int)($price_cents * 100);
        return $this;
    }

    /**
     * @param mixed $quantity
     * @return PaymentSubItem
     */
    public function setQuantity(?int $quantity)
    {
        $this->quantity = $quantity ?? 1;
        return $this;
    }

    /**
     * @param mixed $recurrent
     * @return PaymentSubItem
     */
    public function setRecurrent(bool $recurrent = false)
    {
        $this->recurrent = $recurrent;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'price_cents' => $this->price_cents,
            'quantity' => $this->quantity,
            'recurrent' => $this->recurrent
        ];
    }

}
