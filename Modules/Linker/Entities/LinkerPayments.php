<?php

namespace Modules\Linker\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class LinkerPayments extends Model
{
    use SoftDeletes;

    protected $table = 'linker_payments';

    protected $fillable = [
        'guias_id',
        'linker_cliente_id',
        'linker_payments_id',
        'account' ,
        'id_external' ,
        'id_adjustment' ,
        'barcode' ,
        'due_date' ,
        'description',
        'assignor',
        'assignor_document',
        'discount' ,
        'interest' ,
        'fine',
        'amount' ,
        'transaction_code',
        'transaction_date',
        'payment_confirmation' ,
        'id_schedule' ,
        'schedule_date' ,
        'status' ,
    ];

  

}
