<?php

namespace App\Providers;

use App\Events\EmpresaCadastradaEvent;
use App\Events\PosCadastroNfseEvent;
use App\Events\PosCadastroAlvaraEvent;
use App\Events\PosCadastroCertificadoEvent;
use App\Events\PosCadastroCnpjEvent;
use App\Events\PosCadastroSimplesNacionalEvent;
use App\Listeners\EmpresaCadastradaListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\OsAtividadeUpdated' => [
            'App\Listeners\OsAtividadeFinalizadaListener',
        ],
        EmpresaCadastradaEvent::class => [
            EmpresaCadastradaListener::class,
        ],
    ];

    protected $subscribe = [
        'App\Listeners\PosCadastroEventSubscriber'
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
