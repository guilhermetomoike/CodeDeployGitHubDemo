<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappMessageLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['direction', 'from', 'to', 'text', 'media', 'payload'];

    protected $casts = [
        'payload' => 'object'
    ];
}
