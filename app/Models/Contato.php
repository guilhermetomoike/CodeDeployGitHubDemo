<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Contato extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'contactable_type',
        'contactable_id',
        'tipo',
        'value',
        'optin',
        'options',
    ];

    protected $casts = [
        'options' => 'object',
    ];

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = preg_replace('/(?|( )+|(\\n)+)/', '', $value);
    }

    public static function scopeContactable($query, $type, $id)
    {
        return $query->where('contactable_type', $type)->where('contactable_id', $id);
    }

    public function scopeEmail(Builder $query)
    {
        return $query
            ->where('tipo', 'email')
            ->where('optin', 1)
            ->pluck('value');
    }

    public function scopeCelular(Builder $query, int $optin = null)
    {
        $celulares = $query->where('tipo', 'celular');

        if (!($optin === null)) {
            $celulares->where('optin', $optin);
        }

        return $celulares->pluck('value');
    }

    public function scopeWhatsapp(Builder $query)
    {
        return $query
            ->where('tipo', 'celular')
            ->where('optin', 1)
            ->where('options->is_whatsapp', true)
            ->pluck('value');
    }

    public function responsavel()
    {
        return $this->morphTo('contactable');
    }
}
