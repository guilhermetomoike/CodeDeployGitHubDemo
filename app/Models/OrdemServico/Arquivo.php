<?php

namespace App\Models\OrdemServico;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    protected $table = 'ordem_servico_arquivo';

    protected $fillable = ['nome', 'path', 'os_atividade_id'];
}
