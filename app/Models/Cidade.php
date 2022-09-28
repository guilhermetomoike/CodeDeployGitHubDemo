<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $with = ['estado'];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
