<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AppSettings extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public static function scopePerson($query, $type, $id)
    {
        return $query->where('person_type', $type)->where('person_id', $id);
    }
}
