<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionarioPerguntaEscolha extends Model
{
    protected $table = 'questionario_pergunta_escolhas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionario_pergunta_id',
        'escolha',
        'tipo',
        'outro_informar',
        'mostrar_se_resposta',
        'mostrar_se_pergunta_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'questionario_pergunta_id' => 'integer',
        'outro_informar' => 'boolean',
        'mostrar_se_pergunta_id' => 'integer',
    ];


    public function questionarioPergunta()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPergunta::class);
    }

    public function mostrarSePergunta()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPergunta::class);
    }
}
