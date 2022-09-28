<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;

class IrpfPendenciaType extends Model
{
    protected $table = 'irpf_pendencia';

    protected $fillable = [
        'irpf_questionario_id',
        'nome',
        'descricao'
    ];

    public function inputs()
    {
        return $this->hasMany(IrpfInputPendencia::class, 'irpf_pendencia_id', 'id');
    }

    public function pendenciaInputs()
    {
        return $this->hasMany(IrpfItemEnviado::class, 'irpf_pendencia_id', 'id');
    }
}
