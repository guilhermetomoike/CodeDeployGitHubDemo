<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'usuario_id',
        'conteudo',
        'status',
        'etapas_id'
    ];

    public function scopeCommentable($query, $type, $id)
    {
        return $query->where('commentable_type', $type)->where('commentable_id', $id);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class)->withTrashed();
    }
}
