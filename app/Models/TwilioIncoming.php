<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwilioIncoming extends Model
{
    public $incrementing = false;

    protected $primaryKey = false;

    protected $table = 'twilio_incoming';

    protected $fillable = [
        'twilio_incoming', 'SmsMessageSid', 'NumMedia', 'SmsSid', 'SmsStatus', 'Body', 'To', 'NumSegments',
        'MessageSid', 'AccountSid', 'From',
    ];
}
