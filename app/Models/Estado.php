<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function cidades()
    {
        return $this->hasMany(Cidade::class)->orderBy('nome');
    }

    public function junta_comercial()
    {
        return $this->hasOne(JuntaComercial::class);
    }
}
