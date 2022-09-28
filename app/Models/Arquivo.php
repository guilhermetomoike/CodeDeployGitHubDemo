<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;

class Arquivo extends Model
{
    use LogsActivity;

    protected $fillable = ['model_id', 'model_type', 'nome', 'nome_original', 'caminho', 'tamanho', 'mime_type', 'tags'];

    protected $casts = ['tags' => 'object'];

    protected static $logAttributes = ['model_id', 'model_type', 'nome_original', 'caminho', 'tamanho', 'mime_type', 'tags'];

    protected static $logOnlyDirty = true;

    public function setNomeOriginalAttribute($value)
    {
        $this->attributes['nome_original'] = preg_replace('/{([^]]+)}/', '', $value);
    }

    protected static function booted()
    {
        static::deleting(function ($arquivo) {
            Storage::delete($arquivo->caminho);
        });
    }

    public function scopeByNome(Builder $query, string $nome): Arquivo
    {
        return $query->where('nome', $nome)->firstOrFail();
    }

    public function scopeWithTags(Builder $query, array $tags): Builder
    {
        return $query->whereJsonContains('tags', $tags);
    }
}
