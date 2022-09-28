<?php

namespace Modules\EmpresaAlteracao\Entities;

use Illuminate\Database\Eloquent\Model;

class EmpresaAlteracao extends Model
{
    protected $table = 'empresa_alteracoes';

    protected $fillable = [
        'empresa_id',
        'status_id',
        'solicitacao',
        'alteracao',
    ];

    protected $casts = [
        'id' => 'integer',
        'empresa_id' => 'integer',
        'status_id' => 'integer',
        'solicitacao' => 'array',
        'alteracao' => 'array',
    ];

    public static $status = [
        self::STATUS_PAGAMENTO => 'Aguardando pagamento',
        self::STATUS_ALTERACAO => 'Em processo de alteração',
        self::STATUS_FINALIZADO => 'Finalizado',
    ];

    const STATUS_PAGAMENTO = 1;
    const STATUS_ALTERACAO = 2;
    const STATUS_FINALIZADO = 100;

    public function getStatusLabelAttribute()
    {
        return self::$status[$this->attributes['status_id']] ?? 'Status';
    }

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class);
    }

    public function updateStatus(int $statusId)
    {
        $this->status_id = $statusId;
        $this->save();

        return $this;
    }

    public function scopeNaoFinalizado($query)
    {
        return $query->where('status_id', '<', self::STATUS_FINALIZADO);
    }
}
