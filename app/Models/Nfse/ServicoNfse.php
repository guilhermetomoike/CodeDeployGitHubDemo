<?php

namespace App\Models\Nfse;

use Illuminate\Database\Eloquent\Model;

class ServicoNfse extends Model
{
    protected $table = 'servico_nfse';

    protected $fillable = [
        'id_plugnotas',
        'codigo',
        'cnae',
        'codigoTributacao',
        'discriminacao',
    ];
}
