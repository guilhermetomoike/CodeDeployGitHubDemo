<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionarioParte extends Model
{
    protected $table = 'questionario_partes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionario_pagina_id',
        'titulo',
        'subtitulo',
        'url_imagem',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'questionario_pagina_id' => 'integer',
    ];


    public function questionarioPerguntas()
    {
        return $this->hasMany(\Modules\Questionario\Entities\QuestionarioPergunta::class);
    }

    public function questionarioPagina()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPagina::class);
    }
}
