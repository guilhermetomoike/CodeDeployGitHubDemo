<?php

namespace App\Models\OrdemServico;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use App\Models\Usuario;
use App\Notifications\OrdemServico\OsCreatedNotification;
use App\Services\SlackService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\JoinClause;

class OrdemServico extends Model
{
    use SoftDeletes, HasArquivos;

    protected $table = 'ordem_servico';

    protected $fillable = ['empresa_id', 'cliente_id', 'descricao', 'motivo_cancelamento', 'usuario_id'];

    public function items()
    {
        return $this->hasMany(OrdemServicoItem::class, 'ordem_servico_id', 'id')
            ->join('os_base', 'os_base.id', '=', 'os_item.os_base_id')
            ->select('os_item.*', 'os_base.nome as nome', 'os_base.descricao');
    }

    public function atividades()
    {
        return $this->hasMany(OrdemServicoAtividade::class, 'ordem_servico_id', 'id')
            ->join('os_atividade_base', 'os_atividade.os_atividade_base_id', '=', 'os_atividade_base.id')
            ->select('os_atividade.*', 'os_atividade_base.nome', 'os_atividade_base.descricao', 'os_atividade_base.sla_hora');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id', 'cliente')
            ->select('id', 'nome_completo');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id', 'empresa')
            ->select('id', 'razao_social');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function anexos()
    {
        return $this->arquivos();
    }

    protected static function boot()
    {
        parent::boot();

        self::created(function ($ordemServico) {
            $ordemServico->empresa->notify(new OsCreatedNotification());
        });
    }
}
