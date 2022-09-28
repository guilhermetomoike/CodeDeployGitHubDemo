<?php

namespace App\Listeners;

use App\Events\EmpresaCadastradaEvent;
use App\Jobs\MakeContratoEmpresaJob;
use App\Notifications\EmpresaCadastradaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmpresaCadastradaListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default');
    }

    public function handle(EmpresaCadastradaEvent $event)
    {
        $empresa = $event->getEmpresa();
        if ($empresa->status_id != 9) {
            MakeContratoEmpresaJob::dispatch($empresa);
        }
        $empresa->notify(new EmpresaCadastradaNotification());
    }
}
