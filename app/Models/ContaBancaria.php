<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContaBancaria extends Model
{
    protected $fillable = [
        'cpf_cnpj',
        'agencia',
        'dv_agencia',
        'conta',
        'dv_conta',
        'tipo',
        'pessoa',
        'banco_id',
        'principal',
        'owner_type',
        'owner_id'
    ];

    public static $ownerTypes = ['empresa', 'cliente'];

    public function scopeOwner($query, $type, $id)
    {
        return $query->where('owner_type', $type)->where('owner_id', $id);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function responsavel()
    {
        return $this->morphTo('owner');
    }

    public static function resetPrincipal($owner_type, $owner_id)
    {
        $ownerTypes = [
            'empresa' => Empresa::class,
            'cliente' => Cliente::class
        ];
        $contasBancarias = $ownerTypes[$owner_type]::find($owner_id)->contas_bancarias();
        if ($contasBancarias->count()) {
            $contasBancarias->update(['principal' => false]);
        }
    }
}
