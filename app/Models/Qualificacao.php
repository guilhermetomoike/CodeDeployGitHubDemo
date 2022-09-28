<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualificacao extends Model
{
    protected $table = 'qualificacao';

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
