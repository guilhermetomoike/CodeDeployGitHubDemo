<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEndereco extends Model
{
    protected $table = "endereco_cliente";

    protected $fillable  = ['cep', 'logradouro', 'numero', 'bairro', 'cidade', 'ibge', 'uf', 'complemento'];
}
