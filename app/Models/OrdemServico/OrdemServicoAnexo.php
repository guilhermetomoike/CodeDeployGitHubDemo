<?php

namespace App\Models\OrdemServico;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoAnexo extends Model
{
    use HasArquivos;

    protected $fillable = [
        'arquivo', 'ordem_servico_id'
    ];
}
