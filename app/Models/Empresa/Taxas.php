<?php

namespace App\Models\Empresa;

use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Taxas extends Model
{
    use HasArquivos, LogsActivity,SoftDeletes;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'taxas';
    protected $primaryKey = 'id';
    protected $fillable = ['empresa_id','nome_arquivo','data_vencimento','type_document','document_id','tipo_taxa'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
