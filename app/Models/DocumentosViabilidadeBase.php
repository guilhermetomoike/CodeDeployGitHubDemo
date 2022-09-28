<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosViabilidadeBase extends Model
{
    protected $table = 'documentos_viabilidade_base';

    protected $fillable = ['name'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }
}
