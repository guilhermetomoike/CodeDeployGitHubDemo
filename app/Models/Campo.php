<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    protected $table = 'os_atividades_campos_base';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'tipo',
        'atividade_id',
    ];
}
