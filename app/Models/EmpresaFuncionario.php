<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EmpresaFuncionario extends Model
{

 
    
    protected $table = 'funcionarios';

    protected $fillable = [
        "empresa_id",
        "cpf",
        "salario",
        "nome"
    ];
}
