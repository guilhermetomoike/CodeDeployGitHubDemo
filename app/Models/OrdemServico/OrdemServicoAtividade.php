<?php

namespace App\Models\OrdemServico;

use App\Events\OsAtividadeUpdated;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemServicoAtividade extends Model
{
    use HasArquivos;

    protected $table = 'os_atividade';

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
        'input' => 'object'
    ];

    protected $fillable = ['os_atividade_base_id', 'ordem_servico_id', 'os_item_id', 'data_inicio', 'data_fim', 'status', 'input'];

    public function ordem_servico()
    {
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id', 'id', 'ordem_servico');
    }

    public function ordem_servico_item()
    {
        return $this->belongsTo(OrdemServicoItem::class, 'os_item_id', 'id', 'os_item')
            ->join('os_base', 'os_base.id', '=', 'os_item.os_base_id')
            ->select('os_item.*', 'os_base.nome as nome', 'os_base.descricao');
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function (OrdemServicoAtividade $atividade) {
            if ($atividade->wasChanged('data_fim')) {
                event(new OsAtividadeUpdated($atividade));
            }
        });
    }


}
