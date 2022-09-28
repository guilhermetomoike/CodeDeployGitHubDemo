<?php

namespace Modules\Linker\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class LinkerAgendar extends Model
{
    use SoftDeletes;

    protected $table = 'linker_agendar';

    protected $fillable = [
        'guias_id',
        'linker_cliente_id',
        'linker_payments_id',
        'description',
        'tipo',
        'barcode',
        'amount',
        'cnpj'
    ];

  

}
