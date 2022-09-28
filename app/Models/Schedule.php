<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected $fillable = ['is_active', 'name', 'slug', 'frequency'];

    public static function getBySlug(string $slug)
    {
        return self::query()->firstWhere('slug', $slug);
    }
}
