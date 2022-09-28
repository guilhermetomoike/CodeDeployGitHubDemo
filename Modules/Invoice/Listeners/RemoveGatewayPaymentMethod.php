<?php

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Events\PaymentMethodWasDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Invoice\Services\PaymentAdapter\RemoveGatewayPaymentMethodAdapter;

class RemoveGatewayPaymentMethod
{
    private RemoveGatewayPaymentMethodAdapter $removeService;

    public function __construct(RemoveGatewayPaymentMethodAdapter $removeService)
    {
        $this->removeService = $removeService;
    }

    public function handle(PaymentMethodWasDeleted $event)
    {
        $creditCard = $event->getCreditCard();
        $removed = $this->removeService->execute(
            $creditCard->payer->iugu_id,
            $creditCard->forma_pagamento_gatway_id
        );

        if (!$removed) {
            throw new \Exception('Erro ao remover o cartão do serviço de pagamento');
        }
    }
}
