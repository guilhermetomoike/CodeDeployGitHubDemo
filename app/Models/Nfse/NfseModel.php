<?php

namespace App\Models\Nfse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NfseModel extends Model
{
    use SoftDeletes;

    protected $table = 'empresas_nfse';

    protected $fillable = [
        'id_tecnospeed', 'valor', 'cnpjTomador', 'cnpjPrestador',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id', 'id');
    }
}
