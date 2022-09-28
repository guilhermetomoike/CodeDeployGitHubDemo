<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IrpfClientePendencia extends Model
{
    use SoftDeletes;

    protected $casts = [
        'inputs' => 'array'
    ];

    protected $table = 'irpf_cliente_pendencia';

    protected $fillable = ['irpf_pendencia_id', 'declaracao_irpf_id', 'inputs'];

    public function irpf()
    {
        return $this->belongsTo(DeclaracaoIrpf::class, 'declaracao_irpf_id');
    }
}
