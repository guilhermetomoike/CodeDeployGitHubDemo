<?php

namespace Modules\Questionario\Entities;

use Illuminate\Database\Eloquent\Model;

class QuestionarioPergunta extends Model
{
    protected $table = 'questionario_perguntas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionario_parte_id',
        'titulo',
        'subtitulo',
        'url_imagem',
        'obrigatoria',
        'tipo',
        'tipo_escolha',
        'min',
        'max',
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
        'questionario_parte_id' => 'integer',
        'obrigatoria' => 'boolean',
        'mostrar_se_pergunta_id' => 'integer',
    ];


    public function questionarioPerguntaEscolhas()
    {
        return $this->hasMany(\Modules\Questionario\Entities\QuestionarioPerguntaEscolha::class);
    }

    public function questionarioRespostas()
    {
        return $this->hasMany(\Modules\Questionario\Entities\QuestionarioResposta::class);
    }

    public function questionarioParte()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioParte::class);
    }

    public function mostrarSePergunta()
    {
        return $this->belongsTo(\Modules\Questionario\Entities\QuestionarioPergunta::class);
    }
}
