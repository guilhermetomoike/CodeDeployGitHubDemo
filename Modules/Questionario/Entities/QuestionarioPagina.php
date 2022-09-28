<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionarioPagina extends Model
{
    protected $table = 'questionario_paginas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionario_id',
        'titulo',
        'subtitulo',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'questionario_id' => 'integer',
    ];


    public function questionarioPartes()
    {
        return $this->hasMany(\Modules\Questionario\Entities\QuestionarioParte::class);
    }

    public function questionario()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\Questionario::class);
    }
}
