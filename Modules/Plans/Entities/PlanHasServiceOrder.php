<?php

namespace Modules\Plans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanHasServiceOrder extends Pivot
{
    protected $table = 'plan_has_service_orders';

    protected $fillable = ['quantity', 'os_base_id', 'plan_id'];
}
