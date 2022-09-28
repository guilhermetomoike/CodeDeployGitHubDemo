<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssinaturaPagamento extends Model
{
    protected $table = 'assinatura_pagamento';

    protected $fillable = ['gatway_id', 'gatway'];

    public function payer()
    {
        return $this->morphTo('payer');
    }
}
