<?php

namespace Modules\Irpf\Entities;

use App\Models\Cliente;
use App\Models\IrpfAssets;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeclaracaoIrpf
 *
 * @property $cliente_id
 * @property $ano
 * @property $declaracao
 * @property $recibo
 * @property $realizacao
 * @property $observacao
 * @property $conta_restituicao
 * @property $step
 * @property $qtd_lancamento
 * @property $enviado
 * @property $rural
 * @property $ganho_captal
 * @property $aceitou
 * @property $isento
 * @package Modules\Irpf\Entities
 */
class DeclaracaoIrpf extends Model
{
    use HasArquivos;

    protected $table = 'declaracao_irpf';

    protected $casts = ['conta_restituicao' => 'object'];

    protected $fillable = [
        'cliente_id',
        'ano',
        'declaracao',
        'recibo',
        'realizacao',
        'observacao',
        'conta_restituicao',
        'step',
        'qtd_lancamento',
        'enviado',
        'rural',
        'ganho_captal',
        'aceitou',
        'isento',
        'cancelado',

    ];
    /**
     * @var mixed
     */
    private $cliente_id;

    public function items()
    {
        return $this->hasMany(IrpfClienteResposta::class, 'declaracao_irpf_id', 'id');
    }

    public function assets()
    {
        return $this->hasMany(IrpfAssets::class, 'irpf_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function resposta()
    {
        return $this->hasMany(IrpfClienteResposta::class);
    }

    public function pendencias()
    {
        return $this->hasMany(IrpfClientePendencia::class, 'declaracao_irpf_id', 'id');
    }

}
