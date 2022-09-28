<?php

namespace Modules\Invoice\Console;


use Illuminate\Console\Command;
use Modules\Plans\Entities\PlanSubscription;

class GenerateInvoiceCommand extends Command
{
    protected $name = 'financeiro:fix-plans';

    protected $description = 'command for fix plans of  company to generate correct amounts on the monthly invoice';

    public function handle()
    {
        // $date = Carbon::create()->setDay(15);

        $subscriptions =  PlanSubscription::query()
            // ->with(['payer'])
            ->where('payer_type', 'empresa')

            ->get()->filter(
                fn ($subs) =>
                $subs->payer  &&

                    $subs->payer->status_id == 100
            );
        // return $subscriptions;

        $data = [];
        foreach ($subscriptions as $subscription) {
            // if($subscription->payer->id == 384){
            return $subscription->payer->type;
            if (isset($subscription->payer->residencia_medica)) {

                if ($subscription->plan_id != 2) {
                    PlanSubscription::where('payer_id', $subscription->payer_id)->where('payer_type', 'empresa')->update(['plan_id' => 2]);
                }
            }
            if (!isset($subscription->payer->residencia_medica)) {
                if ($subscription->payer->type == 'atletica') {
                    PlanSubscription::where('payer_id', $subscription->payer_id)->where('payer_type', 'empresa')->update(['plan_id' => 7]);
                } else {
                    if ($subscription->plan_id != 1 and  $subscription->plan_id != 3) {
                        PlanSubscription::where('payer_id', $subscription->payer_id)->where('payer_type', 'empresa')->update(['plan_id' => 1]);
                    }
                }
                // PlanSubscription::where('payer_id',$subscription->payer_id)->find(1)->update(['plan_id'=>1]) ;      
            }
            // return response()->json($subscription->payer->residencia_medica);
        }
        // }
        return 'arrumado';
    }
}
