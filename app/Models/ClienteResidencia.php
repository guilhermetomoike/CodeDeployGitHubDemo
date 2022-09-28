<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class ClienteResidencia extends Model
{
    use HasArquivos;

    protected $table = 'cliente_residencia';

    protected $dates = ['data_inicio', 'data_conclusao'];

    protected $fillable = [
        'data_inicio', 'data_conclusao', 'cliente_id', 'empresa_id', 'usuario_id', 'especialidade'
    ];
}
