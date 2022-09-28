<?php

namespace Modules\Irpf\Providers;

use App\Services\Recebimento\Contracts\Recebimento;
use Illuminate\Support\ServiceProvider;
use Modules\Irpf\Services\CalculateIrpfChargeService;
use Modules\Irpf\Services\ChargerGatwayService;
use Modules\Irpf\Services\Contracts\CalculateChargesInterface;
use Modules\Irpf\Services\Contracts\CreateChargeInterface;
use Modules\Irpf\Services\CreateChargeService;

class ChargeIrpfServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('production')) {
            config()->set('irpf.webhook_charge_url', url('webhook/irpf/charge-notification', [], true));
        } else {
            config()->set('irpf.webhook_charge_url', config('irpf.webhook_charge_url_test') . '/webhook/irpf/charge-notification');
        }

        $this->app->bind(CalculateChargesInterface::class, CalculateIrpfChargeService::class);

        $this->app->bind(CreateChargeInterface::class, CreateChargeService::class);

        $this->app
            ->when(CreateChargeService::class)
            ->needs(Recebimento::class)
            ->give(ChargerGatwayService::class);
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
