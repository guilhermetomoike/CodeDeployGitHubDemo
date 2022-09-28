<?php

namespace Modules\Activity\Entities;

use App\Models\ComentariosEtapasEmpresas;
use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;


class EtapasEmpresas extends Model
{
    use SoftDeletes;
    protected $table = 'etapas_empresas';

    
    protected $fillable = [
        'id',
        'status',
        'atividades_id',
        'empresa_id',
        'etapas_id'
    ];

    
    public function etapa()
    {
        return $this->hasOne(Etapas::class,'id','etapas_id');
    }
    public function atividade()
    {
        return $this->hasOne(Atividades::class,'id','atividades_id');
    }
    public function empresa()
    {
        return $this->hasOne(Empresa::class,'id','empresa_id');
    }
    public function comentarios_etapas_empresas()
    {
        return $this->hasMany(ComentariosEtapasEmpresas::class,'etapas_empresas_id','id');
    }
}
