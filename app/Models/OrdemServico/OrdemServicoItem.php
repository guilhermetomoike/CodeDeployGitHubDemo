<?php

namespace App\Models\OrdemServico;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoItem extends Model
{
    protected $table = 'os_item';

    protected $casts = [
        'data_limite' => 'datetime',
        'email_enviado' => 'datetime',
        'competencia' => 'datetime',
    ];

    protected $fillable = ['os_base_id', 'ordem_servico_id', 'data_limite', 'competencia', 'preco', 'usuario_id', 'email_enviado'];

    public function atividades()
    {
        return $this->hasMany(OrdemServicoAtividade::class, 'os_item_id', 'id')
            ->join('os_atividade_base', 'os_atividade.os_atividade_base_id', '=', 'os_atividade_base.id')
            ->select('os_atividade.*', 'os_atividade_base.nome', 'os_atividade_base.descricao', 'os_atividade_base.sla_hora');
    }

    public function os_base()
    {
        return $this->hasOne(OrdemServicoBase::class, 'id', 'os_base_id');
    }

    public function atividades_base()
    {
        return $this->hasMany(OsAtividadeBase::class, 'os_base_id', 'os_base_id');
    }

    public function ordem_servico()
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id', 'id', 'ordem_servico');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }

    public function arquivos()
    {
        return $this->hasManyThrough(
            \App\Models\Arquivo::class,
            OrdemServicoAtividade::class,
            'os_item_id',
            'model_id'
        )->where('model_type', 'ordem_servico_atividade');
    }
}
