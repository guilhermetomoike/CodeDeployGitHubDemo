<?php

namespace App\Models\Empresa;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;

class MotivoDesativacao extends Model
{
    protected $table = 'empresa_motivo_desativado';

    protected $fillable = [
        'motivo', 'descricao', 'usuario_id', 'empresa_id', 'data_competencia', 'data_encerramento'
    ];

    public function responsavel()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }
}
