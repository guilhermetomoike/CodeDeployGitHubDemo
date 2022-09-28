<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;

class IrpfClienteResposta extends Model
{
    protected $table = 'irpf_cliente_resposta';

    protected $fillable = ['irpf_questionario_id', 'resposta', 'quantidade', 'declaracao_irpf_id'];

    public function pendencia()
    {
        return $this->hasOneThrough(
            IrpfPendenciaType::class,
            IrpfQuestionario::class,
            'id',
            'irpf_questionario_id',
            'irpf_questionario_id',
            'id'
        );
    }

    public function questionario()
    {
        return $this->belongsTo(IrpfQuestionario::class, 'irpf_questionario_id');
    }

}
