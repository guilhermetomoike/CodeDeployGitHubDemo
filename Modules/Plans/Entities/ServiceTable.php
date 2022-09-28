<?php

namespace Modules\Plans\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTable extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'price'];
}
