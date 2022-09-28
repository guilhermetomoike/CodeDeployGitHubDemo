<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'iptu',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'ibge',
        'tipo',
    ];

    public function scopeAddressable($query, $type, $id)
    {
        return $query->where('addressable_type', $type)->where('addressable_id', $id);
    }

    public function empresa()
    {
        return $this
           ->belongsTo(Empresa::class, 'enderecos.addressable_id', 'empresas.id')
           ->where('enderecos.addressable_type', '=', 'App\Models\Empresa');
    }

    public function responsavel()
    {
        return $this->morphTo('addressable');
    }
}
