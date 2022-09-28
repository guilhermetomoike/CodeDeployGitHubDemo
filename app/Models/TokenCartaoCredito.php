<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenCartaoCredito extends Model
{
    protected $table = 'token_cartao_credito';

    protected $fillable = ['token', 'cartao_truncado', 'cliente_id', 'empresa_id', 'principal'];
}
