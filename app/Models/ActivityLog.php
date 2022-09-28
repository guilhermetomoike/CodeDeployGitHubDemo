<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{


    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'causer_id',
        'causer_type',
        'properties'
    ];

}