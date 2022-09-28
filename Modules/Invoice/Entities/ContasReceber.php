<?php

namespace Modules\Invoice\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class ContasReceber extends Model
{
    use SoftDeletes;

    protected $table = 'contas_receber';

    protected $fillable = [
        'payer_id',
        'payer_type',
        'valor',
        'vencimento',
        'consumed_at',
        'descricao',
    ];

  

    public function movimento()
    {
        return $this
            ->hasMany(MovimentoContasReceber::class, 'contas_receber_id')
            ->orderBy('created_at', 'desc');
    }

    public function payer()
    {
        return $this->morphTo('payer');
    }




}
