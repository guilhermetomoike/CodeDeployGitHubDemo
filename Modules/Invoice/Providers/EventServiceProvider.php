<?php

namespace Modules\Invoice\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Invoice\Events\CreditCardWasCreated;
use Modules\Invoice\Events\PaymentMethodWasDeleted;
use Modules\Invoice\Listeners\RegisterNewCreditCardOnGateway;
use Modules\Invoice\Listeners\RemoveGatewayPaymentMethod;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CreditCardWasCreated::class => [
            RegisterNewCreditCardOnGateway::class,
        ],
        PaymentMethodWasDeleted::class => [
            RemoveGatewayPaymentMethod::class
        ]
    ];

}
