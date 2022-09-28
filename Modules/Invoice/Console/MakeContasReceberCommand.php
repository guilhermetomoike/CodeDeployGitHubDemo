<?php

namespace Modules\Invoice\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Invoice\Jobs\CreateContasReceberJob;
use Modules\Invoice\Jobs\FaltantesContasReceberJob;
use Modules\Plans\Repositories\PlanSubscriptionRepository;

class MakeContasReceberCommand extends Command
{
    protected $name = 'financeiro:make-contas-receber';

    protected $description = 'Criar contas a receber para cliente que não o possuem porem já estão pronto para cobrança.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(PlanSubscriptionRepository $subscriptionRepository)
    {
        $subscriptions = $subscriptionRepository->getSubscriptionsMissingContasReceber();

        foreach ($subscriptions as $subscription) {
        

            FaltantesContasReceberJob::dispatch($subscription->payer);
        }
    }
}
