<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faturamento extends Model
{
    protected $table = 'empresas_faturamentos';

    protected $fillable = [
        'faturamento',
        'mes',
        'empresas_id'
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id');
    }
}
