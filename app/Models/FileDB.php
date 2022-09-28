<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileDB extends Model
{
    protected $table = 'files_db';

    protected $fillable = [
        'caminho',
        'lido',
    ];
}
