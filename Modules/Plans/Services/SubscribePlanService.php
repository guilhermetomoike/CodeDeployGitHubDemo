<?php


namespace Modules\Plans\Services;


use App\Models\Payer\Payer;
use App\Models\Payer\PayerContract;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;

class SubscribePlanService implements Contracts\SubscribePlanService
{
    public function execute(array $data)
    {
        $payerModel = Relation::getMorphedModel($data['payer_type']);
        /** @var PayerContract|Payer $payer */
        $payer = $payerModel::find($data['payer_id']);

        $ids = Arr::flatten($data['plans']);
        $payer->plans()->sync($ids);

        return $payer->fresh('plans');
    }
}
