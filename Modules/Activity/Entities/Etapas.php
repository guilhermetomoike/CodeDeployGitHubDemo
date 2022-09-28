<?php

namespace Modules\Activity\Entities;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;


class Etapas extends Model
{
    use SoftDeletes;
    protected $table = 'etapas';

    
    protected $fillable = [
        'id',
        'titulo',
        'subtitulo',
        'tempo',
        'status',
        'atividades_id',
        'empresa_id',
        'created_at'
    ];

    public function atividade()
    {
        return $this->hasOne(Atividades::class,'id','atividades_id');
    }
    public function Empresa()
    {
        return $this->hasOne(Empresa::class,'id','empresa_id');
    }
}
