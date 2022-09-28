<?php

namespace Modules\Invoice\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class TipoCobranca extends Model
{
    use SoftDeletes;

    protected $table = 'tipo_cobrancas';

    protected $fillable = [
        'nome',
        'valor',
        'descricao',
   
    ];


}
