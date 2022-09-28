<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    public $table = 'bancos';

    public $timestamps = false;

    protected $primaryKey = 'id';
}
