<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
