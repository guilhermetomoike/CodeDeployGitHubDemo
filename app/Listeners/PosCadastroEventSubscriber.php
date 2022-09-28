<?php

namespace App\Listeners;

use App\Events\PosCadastroAlvaraEvent;
use App\Events\PosCadastroCertificadoEvent;
use App\Events\PosCadastroCnpjEvent;
use App\Events\PosCadastroDocumentationEvent;
use App\Events\PosCadastroFinalizadaEvent;
use App\Events\PosCadastroNfseEvent;
use App\Events\PosCadastroSimplesNacionalEvent;
use App\Notifications\AberturaEmpresas\AlvaraNotification;
use App\Notifications\AberturaEmpresas\CertificadoDigitalNotification;
use App\Notifications\AberturaEmpresas\CnpjNotification;
use App\Notifications\AberturaEmpresas\NfseNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Invoice\Jobs\CreateContasReceberJob;

class PosCadastroEventSubscriber
{
    public function handleStepCertificado(PosCadastroCertificadoEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 4;
        $empresa->save();
        $empresa->notify(new CertificadoDigitalNotification());
    }

    public function handleStepDocumentation(PosCadastroDocumentationEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 4;
        $empresa->notify(new CertificadoDigitalNotification());
        $empresa->save();
    }

    public function handleStepCnpj(PosCadastroCnpjEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 5;
        $empresa->save();
        $empresa->notify(new CnpjNotification());
    }

    public function handleStepAlvara(PosCadastroAlvaraEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 6;
        $empresa->save();
        $empresa->notify(new AlvaraNotification());
        CreateContasReceberJob::dispatch($empresa,true);
    }

    public function handleStepNfse(PosCadastroNfseEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = ($empresa->regime_tributario == 'SN') ? 7 : 99;
        $empresa->save();
        $empresa->notify(new NfseNotification());
    }

    public function handleStepSimplesNacional(PosCadastroSimplesNacionalEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 99;
        $empresa->save();
        $empresa->notify(new NfseNotification());
    }

    public function handleStepFinalizada(PosCadastroFinalizadaEvent $event)
    {
        $empresa = $event->getEmpresa();
        $empresa->status_id = 100;
        $empresa->save();
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'App\Events\PosCadastroCertificadoEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepCertificado'
        );

        $events->listen(
            'App\Events\PosCadastroDocumentationEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepDocumentation'
        );

        $events->listen(
            'App\Events\PosCadastroCnpjEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepCnpj'
        );

        $events->listen(
            'App\Events\PosCadastroAlvaraEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepAlvara'
        );

        $events->listen(
            'App\Events\PosCadastroNfseEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepNfse'
        );

        $events->listen(
            'App\Events\PosCadastroSimplesNacionalEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepSimplesNacional'
        );

        $events->listen(
            'App\Events\PosCadastroFinalizadaEvent',
            'App\Listeners\PosCadastroEventSubscriber@handleStepFinalizada'
        );
    }
}
