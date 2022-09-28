<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class RequiredGuide extends Model
{
    protected  $fillable = ['name', 'type', 'active'];

    protected $table = 'required_guides';
}
