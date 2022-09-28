<?php

namespace App\Models\Cliente;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class ClientAccess extends Model
{
    protected $table = 'client_access';

    protected $fillable = ['client_id', 'login', 'password', 'url', 'type'];

    protected $primaryKey = 'id';

    const INSS = 'inss';

    const TYPE = [
        self::INSS
    ];
}
