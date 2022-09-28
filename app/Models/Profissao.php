<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profissao extends Model
{
    protected $table = 'profissao';

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
