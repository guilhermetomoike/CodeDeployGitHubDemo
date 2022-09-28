<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresasFaturamento extends Model
{
    protected $table = 'empresas_faturamentos';

    protected $fillable = [
        'faturamento',
        'empresas_id'
    ];
}
