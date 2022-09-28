<?php

namespace Modules\Invoice\Events;

use App\Models\CartaoCredito;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreditCardWasCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private CartaoCredito $creditCard;

    public function __construct(CartaoCredito $creditCard)
    {
        $this->creditCard = $creditCard;
    }

    public function getCreditCard(): CartaoCredito
    {
        return $this->creditCard;
    }

}
