<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IrpfAssets extends Model
{
    protected $fillable = [
        'code',
        'description',
        'value',
        'next_confirmed'
    ];
}
