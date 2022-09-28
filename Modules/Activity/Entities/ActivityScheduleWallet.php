<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityScheduleWallet
 * @package Modules\Activity\Entities
 *
 * @property integer activity_schedules_id
 * @property integer carteira_id
 */
class ActivityScheduleWallet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'activity_schedules_id',
        'carteira_id',
    ];
}
