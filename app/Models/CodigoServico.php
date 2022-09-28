<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoServico extends Model
{
    protected $table = 'codigos_servicos';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
