<?php

namespace Modules\Invoice\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Services\Webhook\ChangeInvoiceStatus;
use Modules\Invoice\Services\Webhook\IChangeInvoiceStatus;

class WebhookInvoiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IChangeInvoiceStatus::class, ChangeInvoiceStatus::class);
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
