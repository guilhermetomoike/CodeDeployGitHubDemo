<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaMotivoCongelamento extends Model
{
    protected $table = 'empresas_usuarios_cong';

    protected $fillable = [
        'empresas_id', 'usuarios_id', 'data_congelamento', 'data_competencia', 'previsao_retorno',
        'motivo_congelamento', 'freeze_date'
    ];

    public function responsavel()
    {
        return $this->query()
            ->select(['usuarios.*'])
            ->from('usuarios')
            ->where('usuarios.id', $this->usuarios_id)
            ->first();
    }
}
