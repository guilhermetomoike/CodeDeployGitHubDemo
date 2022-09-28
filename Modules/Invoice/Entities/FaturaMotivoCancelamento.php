<?php

namespace Modules\Invoice\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class FaturaMotivoCancelamento extends Model
{
    use SoftDeletes;

    protected $table = 'fatura_motivo_cancelamento';

    protected $fillable = [
        'nome',
        'descricao',
   
    ];


}
