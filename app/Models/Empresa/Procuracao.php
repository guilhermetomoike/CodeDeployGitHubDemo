<?php

namespace App\Models\Empresa;

use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Procuracao extends Model
{
    use HasArquivos, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'procuracao';

    protected $fillable = ['empresa_id','nome_arquivo','data_vencimento','tipo'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
