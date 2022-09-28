<?php

namespace Modules\Plans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanSubscription extends Pivot
{
    use SoftDeletes;

    protected $table = 'plan_subscriptions';

    protected $fillable = ['payer_id', 'payer_type', 'plan_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function payer()
    {
        return $this->morphTo('payer');
    }
}
