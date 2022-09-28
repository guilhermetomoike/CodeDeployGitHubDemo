<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwilioOutgoing extends Model
{
    protected $table = 'twilio_outgoing';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = [
        'account_sid', 'body', 'error_code', 'error_message', 'from', 'messaging_service_sid', 'num_media',
        'num_segments', 'price', 'price_unit', 'sid', 'status', 'media', 'to',
    ];
}
