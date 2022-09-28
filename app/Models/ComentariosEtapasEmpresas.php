<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Activity\Entities\EtapasEmpresas;

class ComentariosEtapasEmpresas extends Model
{
    use SoftDeletes;


    protected $table = 'comentarios_etapas_empresas';

    protected $fillable = [
        'etapas_empresas_id',
        'comentarios_id',
        'tipo'
    ];

    public function etapas_empresas()
    {
        return $this->hasOne(EtapasEmpresas::class,'id','etapas_empresas_id');
    }
    public function comentario()
    {
        return $this->hasOne(Comentario::class,'id','comentario_id');
    }
 
}
