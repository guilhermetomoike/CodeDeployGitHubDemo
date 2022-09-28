<?php

namespace Modules\Activity\Entities;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * Class Activity
 * @package Modules\Activity\Entities
 *
 * @property integer id
 * @property integer empresa_id
 * @property boolean executed
 * @property string description
 * @property Date goal
 * @property Date deadline
 * @property string tax_regime
 * @property string observation
 * @property integer activity_schedule_id
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Activity extends Model
{
    protected $fillable = [
        'id',
        'empresa_id',
        'executed',
        'description',
        'goal',
        'deadline',
        'tax_regime',
        'observation',
        'activity_schedule_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
