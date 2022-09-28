<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoDesativar extends Model
{
    use SoftDeletes;

    protected $table = 'motivo_desativar';

    protected $fillable = [
        'motivo',
    ];
}
