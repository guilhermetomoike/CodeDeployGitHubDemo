<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuiasDatasPadrao extends Model
{
    protected $table = 'guias_datas_padrao';

    protected $fillable = ['data_vencimento'];
}
