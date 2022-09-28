<?php

namespace App\Models\OrdemServico;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Plans\Entities\Plan;

class OrdemServicoBase extends Model
{
    use SoftDeletes;

    protected $table = 'os_base';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'role_id',
        'procedimento_interno',
        'pagamento_antecipado',
        'notificacao'
    ];

    public function atividades()
    {
        return $this->hasMany(OsAtividadeBase::class, 'os_base_id', 'id');
    }
}
