<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioVenda extends Model
{
    protected $table = 'vendas_usuario';

    protected $fillable = [
        'empresa_id', 'cliente_id', 'usuario_id', 'valor',
    ];
}
