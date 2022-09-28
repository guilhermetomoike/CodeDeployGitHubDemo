<?php

namespace Modules\Onboarding\Entities;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    protected $fillable = ['nome', 'tipo_id'];

    protected $appends = ['tipo'];

    const TIPO_EMPRESA_POSCADASTRO = 1;

    public static $tipos = [
        self::TIPO_EMPRESA_POSCADASTRO => 'empresa-poscadastro',
    ];

    public function getTipoAttribute()
    {
        return self::$tipos[$this->attributes['tipo_id']] ?? 'undefined';
    }

    public function items()
    {
        return $this->hasMany(OnboardingItem::class);
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo_id', $tipo);
    }
}
