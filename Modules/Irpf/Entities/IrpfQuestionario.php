<?php

namespace Modules\Irpf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IrpfQuestionario extends Model
{
    use SoftDeletes;

    protected $table = 'irpf_questionario';

    protected $fillable = [
        'pergunta', 'quantitativo', 'order', 'ativo', 'visivel_cliente', 'descricao', 'gera_pendencia','ano'
    ];

    public function pendencia()
    {
        return $this->hasOne(IrpfPendenciaType::class, 'irpf_questionario_id', 'id');
    }

    public function resposta()
    {
        return $this->hasOne(IrpfClienteResposta::class);
    }
}
