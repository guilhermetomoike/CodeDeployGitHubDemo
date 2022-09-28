<?php

namespace App\Models\Empresa;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class AcessoPrefeitura extends Model
{
    use HasArquivos;

    protected $table = 'empresas_acessos';

    protected $fillable = ['login', 'senha', 'site', 'tipo', 'empresas_id'];

    protected $primaryKey = 'id';

    const EMISSOR = 'emissor';
    const ALVARA = 'alvara';
    const PREFEITURA = 'prefeitura';
    const DEISS = 'deiss';


    const TIPOS = [
        self::EMISSOR,
        self::ALVARA,
        self::PREFEITURA,
        self::DEISS,

    ];
}
