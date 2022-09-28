<?php

namespace Modules\Invoice\Console;


use Illuminate\Console\Command;
use Modules\Invoice\Repositories\RotinasFinanRepository;
use Modules\Invoice\Repositories\RotinasPlanosValoresRepository;
use Modules\Plans\Entities\PlanSubscription;

class UpdatePlanosCommanad extends Command
{
    protected $name = 'financeiro:update-planos';

    protected $description = 'Command for generate all recurrent invoices for the month.';

    public function handle(RotinasPlanosValoresRepository $rotinasPlanosValoresRepository)
    {
        $subscriptions =  PlanSubscription::query()
        // ->with(['payer'])
        ->where('payer_type', 'empresa')

        ->with(['payer' => function ($payer) {
            $payer->where('congelada', 0);
            // $payer->where('status_id', '<>', 81);
            $payer->whereIn('status_id', [100, 99]);
        }])->get();
        $rotinasPlanosValoresRepository->arrumasPlanoEmpresas($subscriptions);
        $rotinasPlanosValoresRepository->arrumasPlanoAgendamento($subscriptions);


    }
}
