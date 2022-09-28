<?php

namespace Modules\Plans\Entities;

use App\Models\OrdemServico\OrdemServicoBase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $dates = ['start_on'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'price',
        'interval',
        'interval_type',
        'payable_with',
        'start_on',
    ];

    public static array $types = [
        'normal' => 'Normal',
        'pf' => 'Pessoa física',
        'clinica' => 'Clinica',
        'atletica' => 'Atlética',
    ];

    public function service_order()
    {
        return $this->belongsToMany(
            OrdemServicoBase::class,
            PlanHasServiceOrder::class,
            'plan_id',
            'os_base_id'
        );
    }

    public function service_table()
    {
        return $this->belongsToMany(
            ServiceTable::class,
            PlanHasServiceTable::class
        );
    }

}
