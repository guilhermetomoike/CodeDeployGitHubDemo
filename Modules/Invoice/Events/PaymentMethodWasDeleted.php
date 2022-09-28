<?php

namespace Modules\Invoice\Events;

use App\Models\CartaoCredito;
use Illuminate\Queue\SerializesModels;

class PaymentMethodWasDeleted
{
    use SerializesModels;

    private CartaoCredito $cartaoCredito;

    public function __construct(CartaoCredito $cartaoCredito)
    {
        $this->cartaoCredito = $cartaoCredito;
    }

    public function getCreditCard(): CartaoCredito
    {
        return $this->cartaoCredito;
    }

    public function broadcastOn()
    {
        return [];
    }
}
