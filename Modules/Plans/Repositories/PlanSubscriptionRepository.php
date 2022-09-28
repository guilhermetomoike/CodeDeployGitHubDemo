<?php

namespace Modules\Plans\Repositories;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder;
use Modules\Plans\Entities\PlanSubscription;

class PlanSubscriptionRepository
{
    public function create(array $data)
    {
        return PlanSubscription::query()->create($data);
    }

    public function getSubscriptions()
    {
        $empresas = Empresa::with(['plans', 'cartao_credito'])->whereHas('plans')->get();
        $clientes = Cliente::with(['plans', 'cartao_credito'])->whereHas('plans')->get();
        return $empresas->merge($clientes);
    }

    public function delete(array $data)
    {
        return PlanSubscription::query()
            ->where($data)
            ->delete();
    }

    public function getSubscriptionsMissingContasReceber()
    {
        return PlanSubscription::query()
            ->with(['payer'])
            ->whereHasMorph('payer', '*', function (Builder $payer) {
                $payer->whereDoesntHave('ContasReceber');
            })
            ->get()
            ->filter(
                fn ($subscription) =>
                !$subscription->payer->congelada 
                && $subscription->payer->status_id == 100
                && $subscription->payer->status_id == 99
                

            );
    }
}
