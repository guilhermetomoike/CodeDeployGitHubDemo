<?php

namespace App\Models\Nfse;

use Illuminate\Database\Eloquent\Model;

class EmpresaServicoNfse extends Model
{
    protected $table = 'empresa_servico_nfse';

    protected $casts = [
        'retencao' => 'array'
    ];

    protected $fillable = [
        'tomador_id', 'empresa_id', 'servico_nfse_id', 'aliquota', 'iss_retido', 'discriminacao', 'retencao',
        'valor', 'email_envio'
    ];

    public function tomador()
    {
        return $this->hasOne(TomadorNfse::class, 'id', 'tomador_id');
    }

    public function servico()
    {
        return $this->hasOne(ServicoNfse::class, 'id', 'servico_nfse_id');
    }
}
