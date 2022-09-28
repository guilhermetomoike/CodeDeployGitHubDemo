<?php

namespace Modules\Invoice\Entities;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\Relation;

class Fatura extends Model
{
    use HasArquivos, LogsActivity, SoftDeletes;

    protected $table = 'fatura';

    protected $dates = ['data_competencia', 'data_vencimento', 'data_recebimento'];

    protected $fillable = [
        'subtotal', 'teto', 'desconto', 'data_competencia', 'data_vencimento', 'status', 'em_conjunto',
        'data_recebimento', 'arquivo', 'gatway_fatura_id', 'fatura_url', 'payer_type', 'payer_id', 'juros',
        'multa', 'pix_qrcode_text', 'forma_pagamento_id','fatura_url_boleto','motivo_cancelamento_id','conta_receber_id','tipo_cobrancas_id'
        
    ];
    //,'socios'

    protected $attributes = [
        'status' => 'pendente',
    ];

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    public function items()
    {
        return $this->hasMany(FaturaItem::class, 'fatura_id', 'id');
    }
    // public function contas_receber()
    // {
    //     return $this->hasMany(ContasReceber::class, 'id', 'conta_receber_id');
    // }
    public function movimento()
    {
        return $this->hasMany(MovimentoContasReceber::class, 'contas_receber_id','conta_receber_id');
    }

    public function payer()
    {
        return $this->morphTo('payer');
      
    }

    public function tipo_cobranca()
    {
        return $this->hasOne(TipoCobranca::class, 'id','tipo_cobrancas_id');
    }




    public function voucher()
    {
        return $this->hasOne(Voucher::class);
    }

}
