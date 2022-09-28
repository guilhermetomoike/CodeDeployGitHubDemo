<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satisfacao extends Model
{
    use SoftDeletes;
    protected $table = 'satisfacao';

    protected $fillable = [
        'comentario', 'cliente_id','satisfacao'
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class,'id', 'cliente_id');
    }
  
}