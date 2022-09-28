<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoRegimeTributario extends Model
{
    protected $table = 'historico_regime_tributario';

    protected $fillable = [
        'occurred_at',
        'description',
        'empresa_id',
        'old_value',
        'new_value',
        'usuario_id',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($item) {
            $user = auth('api_usuarios')->user();
            if ($user && $user->getAuthIdentifier()) {
                $item->usuario_id = $user->getAuthIdentifier();
            }
        });
    }
}
