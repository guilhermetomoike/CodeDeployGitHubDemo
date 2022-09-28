<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;

class FaturaItem extends Model
{
    protected $table = 'fatura_item';

    protected $fillable = [
        'valor', 'fatura_id', 'planos_id', 'descricao', 'qtd'
    ];
}
