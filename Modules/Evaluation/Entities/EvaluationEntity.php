<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;

class EvaluationEntity extends Model
{
    protected $fillable = [
        'answer',
        'observation',
        'evaluable_id',
        'evaluable_type',
        'evaluation_id',
        'customer_id',
        'user_id',
    ];

    public static function evaluation($evaluation_id, $type, $id)
    {
        return self::query()
            ->where('evaluable_type', $type)
            ->where('evaluable_id', $id)
            ->where('evaluation_id', $evaluation_id);
    }

    public function evaluate()
    {
        return $this->morphTo('evaluation');
    }
}
