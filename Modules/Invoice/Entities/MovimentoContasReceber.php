<?php

namespace Modules\Invoice\Entities;

use Illuminate\Database\Eloquent\Model;

class MovimentoContasReceber extends Model
{
    protected $table = 'movimento_contas_receber';

    protected $fillable = ['valor','descricao','contas_receber_id'];

    public function conta_receber()
    {
        return $this->belongsTo(ContasReceber::class, 'contas_receber_id');
    }
}
