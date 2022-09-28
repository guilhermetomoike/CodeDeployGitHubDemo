<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class Questionario extends Model
{
    protected $table = 'questionarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
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
    ];


    public function questionarioPaginas()
    {
        return $this->hasMany(\Modules\Questionario\Entities\QuestionarioPagina::class);
    }
}
