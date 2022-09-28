<?php

namespace Modules\Linker\Entities;

use App\Models\Empresa;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class LinkerCliente extends Model
{
    use SoftDeletes;

    protected $table = 'linker_cliente';

    protected $fillable = [
        'empresas_id',
        'clientes_id',
        'token',
        'permission_pay',
        'mailingAddress',
        'companyRevenue',
        'companyPartnerChanged',
        'partnerPEP',
        'token_extrato'
    ];

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresas_id');
    }

  

}
