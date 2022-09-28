<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaEndereco extends Model
{
    protected $table = 'endereco_empresa';

    protected $fillable = [
        'codigo_ibge'
    ];
}
