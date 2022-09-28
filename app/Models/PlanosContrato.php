<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanosContrato extends Model
{
    protected $fillable = [
        'texto', 'planos_id'
    ];

    protected $table = 'planos_contrato';

    public static function getContratoPieces($planos_id)
    {
        return self::query()->whereIn('plano_id', $planos_id)->get()->pluck('texto');
    }
}
