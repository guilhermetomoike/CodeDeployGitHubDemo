<?php

namespace Modules\Activity\Entities;

use App\Models\Empresa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;


class Atividades extends Model
{
    use SoftDeletes;
    protected $table = 'atividades';

    protected $fillable = [
        'id',
        'nome',
        'tempo',
        'status_id'
    ];

  
    public function etapas()
    {
        return $this->belongsTo(Etapas::class,'atividade_id','id');
    }
}
