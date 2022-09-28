<?php

namespace Modules\Invoice\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Http\Controllers\PaymentMethodController;
use Modules\Invoice\Services\PaymentMethod\IPaymentMethodService;
use Modules\Invoice\Services\PaymentMethod\PaymentMethodService;

class PaymentMethodServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IPaymentMethodService::class, PaymentMethodService::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
