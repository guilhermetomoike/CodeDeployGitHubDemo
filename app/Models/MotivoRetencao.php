<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoRetencao extends Model
{
    use SoftDeletes;
    protected $table = 'motivo_retencao';

    protected $fillable = [
        'motivo', 
    ];

  
}
