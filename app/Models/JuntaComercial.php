<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuntaComercial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_id',
        'taxa_alteracao',
        'taxa_alteracao_extra',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'estado_id' => 'integer',
        'taxa_alteracao' => 'decimal:2',
        'taxa_alteracao_extra' => 'decimal:2',
    ];


    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class);
    }
}
