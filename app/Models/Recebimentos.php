<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recebimentos extends Model
{
    protected $table = 'recebimentos';

    public function cliente()
    {
        return $this->belongsTo('App\Model\Cliente\Cliente', 'clientes_id');
    }
}
