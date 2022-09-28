<?php

namespace Modules\Invoice\Repositories;

use App\Models\Empresa;
use Carbon\Carbon;
use Modules\Invoice\Entities\MovimentoContasReceber;
use Modules\Invoice\Services\CreateAdicionaisService;
use Modules\Plans\Entities\PlanSubscription;

class RotinasPlanosValoresRepository
{



    public function arrumasPlanoAgendamento($subscriptions)
    {
        $data = [];
        $mes = Carbon::now()->setDay(20)->format('Y-m-d');
        foreach ($subscriptions as $subscription) {
            if (isset($subscription->payer->contasreceber)) {
                foreach ($subscription->payer->contasreceber as $c) {
                    if ($c->vencimento == $mes) {
                        $valor = 0;
                        $valor =  $subscription->payer->plans[0]->price;
                        if ($c->valor  != 178) {
                            if ($c->valor != $valor) {
                                $c->valor =  $valor;
                                $c->save();
                                $data[] = ['conta_recerber' => $c, 'movimento' => $c->movimento];
                                MovimentoContasReceber::where('descricao', 'like', '%Lançamento de Honorário%')->where('contas_receber_id', $c->id)->update(['valor' => $valor]);
                            }
                        }
                    }
                }
            }
        }
    }

    public function arrumasPlanoEmpresas($subscriptions)
    {
        foreach ($subscriptions as $subscription) {
            // if($subscription->payer->id == 384){
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
            }
        }
    }
}
