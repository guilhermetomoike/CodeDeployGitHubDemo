<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retencao extends Model
{
    use SoftDeletes;
    protected $table = 'retencao';

    protected $fillable = [
        'motivo_retencao_id', 'descricao','data_retencao','empresas_id'
    ];

    public function motivo()
    {
        return $this->hasOne(MotivoRetencao::class,'id', 'motivo_retencao_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class,'empresas_id', 'id');
    }
}
