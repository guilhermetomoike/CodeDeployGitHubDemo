<?php

namespace App\Models\Empresa;

use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Coworking extends Model
{
    use HasArquivos, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'coworking';

    protected $fillable = ['empresa_id','nome_arquivo','data_vencimento'];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
