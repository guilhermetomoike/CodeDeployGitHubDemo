<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertidaoNegativa extends Model
{
    use SoftDeletes, HasArquivos;

    protected $table = 'certidoes_negativas';
    protected $fillable = [
        'empresa_id',
        'tipo',
        'data_emissao',
        'data_validade',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }
}
