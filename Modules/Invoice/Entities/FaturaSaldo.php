<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaSaldo extends Model
{
    use SoftDeletes;

    protected $table = 'fatura_saldo';

    protected $fillable = [
        'payer_type',
        'payer_id',
        'fatura_id',
        'descricao',
        'value',
        'value_type',
        'competencia',
        'cumulative',
        'consumed_at',
    ];
}
