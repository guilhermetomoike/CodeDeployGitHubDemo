<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransacaoRecebimento extends Model
{
    protected $table = 'transacao_recebimento';

    protected $casts = [
        'request' => 'object',
        'response' => 'object'
    ];

    protected $fillable = ['id_externo', 'method', 'gatway', 'valor', 'status', 'descricao', 'request', 'response'];

}
