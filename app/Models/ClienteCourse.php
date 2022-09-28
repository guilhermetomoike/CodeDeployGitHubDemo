<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ClienteCourse extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $with = ['ies', 'course'];

    protected $fillable = ['cliente_id', 'course_id', 'ies_id', 'initial_date', 'conclusion_date', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function ies()
    {
        return $this->belongsTo(Ies::class,'ies_id');
    }

    public function appSettings()
    {
        return $this->morphOne(AppSettings::class, 'person');
    }
}
