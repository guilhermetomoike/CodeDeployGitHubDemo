<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'status',
        'note',
        'labelable_type',
        'labelable_id',
    ];
}
