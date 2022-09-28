<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;

class IrpfItemEnviado extends Model
{
    protected $table = 'irpf_item_enviado';

    protected $fillable = [
        'name', 'value', 'irpf_cliente_resposta_id', 'irpf_pendencia_id', 'irpf_pendencia_input_id',
    ];

    public function input()
    {
        return $this->belongsTo(IrpfInputPendencia::class);
    }
}
