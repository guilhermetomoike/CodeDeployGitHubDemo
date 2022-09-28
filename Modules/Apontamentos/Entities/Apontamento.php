<?php

namespace Modules\Apontamentos\Entities;

use Illuminate\Database\Eloquent\Model;

class Apontamento extends Model
{
    protected $fillable = ['nome', 'sla'];
}
