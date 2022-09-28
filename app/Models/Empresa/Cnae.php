<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class Cnae extends Model
{
    protected $table = 'empresas_cnaes';

    protected $fillable = ['aliquota', 'codigo', 'descricao', 'principal'];
}
