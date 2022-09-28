<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartaoCredito extends Model
{
    use SoftDeletes;

    protected $table = 'cartao_credito';

    protected $fillable = [
        'token_cartao',
        'empresa_id',
        'ano',
        'mes',
        'cartao_truncado',
        'dono_cartao',
        'forma_pagamento_gatway_id',
        'payer_id',
        'payer_type',
        'principal',
        'numero',
        'cvc'
    ];

    public function payer()
    {
        if ($this->empresa_id) {
            return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
        }
        return $this->morphTo('payer');
    }
}
