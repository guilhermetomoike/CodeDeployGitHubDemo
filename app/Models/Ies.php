<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ies extends Model
{
    protected $table = 'ies';

    protected $fillable = ['nome', 'estado', 'faculdade'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
