<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Crm extends Model
{
    use LogsActivity, HasArquivos;

    protected $fillable = ['numero', 'senha', 'estado', 'data_emissao', 'owner_type', 'owner_id'];

    protected static $logAttributes = ['numero', 'senha', 'owner_type', 'owner_id', 'data_emissao'];
    protected static $logOnlyDirty = true;

    public function scopeOwner($query, $type, $id) {
        return $query->where('owner_type', $type)->where('owner_id', $id);
    }

    public function responsavel() {
        return $this->morphTo('owner');
    }

    public function setEstadoAttribute($value)
    {
        $this->attributes['estado'] = strtoupper($value);
    }
}
