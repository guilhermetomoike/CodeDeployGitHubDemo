<?php

namespace App\Models\Empresa;

use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Alvara extends Model
{
    use HasArquivos, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'empresas_alvaras';

    protected $fillable = ['data_vencimento', 'empresa_id','definitivo'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
