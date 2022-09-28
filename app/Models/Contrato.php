<?php

namespace App\Models;

use App\Events\ContratoAssinado;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasArquivos;

    protected $table = 'contratos';

    protected $fillable = [
        'signed_at', 'dia_vencimento', 'empresas_id', 'desconto', 'forma_pagamento_id', 'primeira_mensalidade', 'extra', 'forma_pagamento_gatway_id', 'forma_pagamento_gatway_data'
    ];

    protected $casts = [
        'extra' => 'array',
        'forma_pagamento_gatway_data' => 'object'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }

    public function forma_pagamento()
    {
        return $this->forma_pagamento_id === 1 ? 'boleto' : 'cartao';
    }

}
