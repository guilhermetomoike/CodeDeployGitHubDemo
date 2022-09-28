<?php

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Events\CreditCardWasCreated;
use Modules\Invoice\Services\PaymentAdapter\RegisterGatewayPaymentMethodAdapter;
use Modules\Invoice\Services\PaymentAdapter\RemoveGatewayPaymentMethodAdapter;

class RegisterNewCreditCardOnGateway
{
    private RegisterGatewayPaymentMethodAdapter $registerService;

    public function __construct(RegisterGatewayPaymentMethodAdapter $registerService)
    {
        $this->registerService = $registerService;
    }

    public function handle(CreditCardWasCreated $event)
    {
        $creditCard = $event->getCreditCard();
        $payer = $creditCard->payer;

        $response = $this->registerService->execute($payer, $creditCard->token_cartao);

        if (isset($response['id'])) {
            $payer->cartao_credito()->update(['principal' => false]);
            $creditCard->update([
                'token_cartao' => null,
                'dono_cartao' => $response['data']['holder_name'],
                'cartao_truncado' => $response['data']['display_number'],
                'ano' => $response['data']['year'],
                'mes' => $response['data']['month'],
                'forma_pagamento_gatway_id' => $response['id'],
                'principal' => true,
            ]);
        }
    }
}
