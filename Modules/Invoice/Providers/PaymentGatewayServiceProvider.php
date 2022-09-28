<?php

namespace Modules\Invoice\Providers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Contracts\Invoice\ICancelInvoiceService;
use Modules\Invoice\Services\PaymentAdapter\CancelInvoiceAdapter;
use Modules\Invoice\Services\PaymentAdapter\IHttpAdapter;
use Modules\Invoice\Services\PaymentGatway\IuguHttpAdapter;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IHttpAdapter::class, function (Application $app) {
            $token = base64_encode(config('services.iugu.token'));
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => "Basic $token"
                ],
                'base_uri' => 'https://api.iugu.com/v1/'
            ]);

            return new IuguHttpAdapter($client);
        });

        $this->app->bind(ICancelInvoiceService::class, CancelInvoiceAdapter::class);
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
