<?php

namespace Modules\Invoice\Entities;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasArquivos;

    protected $table = 'voucher';

    protected $with = ['arquivo'];

    protected $fillable = [];
}
