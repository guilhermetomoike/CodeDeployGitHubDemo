<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionarioResposta extends Model
{
    protected $table = 'questionario_respostas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionario_pergunta_id',
        'questionario_pergunta_escolha_id',
        'respondente',
        'resposta',
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
        'questionario_pergunta_escolha_id' => 'integer',
    ];


    public function questionarioPergunta()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPergunta::class);
    }

    public function questionarioPerguntaEscolha()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPerguntaEscolha::class);
    }
}
