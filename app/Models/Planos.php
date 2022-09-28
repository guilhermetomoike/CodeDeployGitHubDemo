<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planos extends Model
{
    protected $table = 'planos';

    public function contrato()
    {
        return $this->hasOne(PlanosContrato:: class, 'plano_id', 'id')->select('texto');
    }
}
