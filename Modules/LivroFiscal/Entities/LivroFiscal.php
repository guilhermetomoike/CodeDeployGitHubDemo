<?php

namespace Modules\LivroFiscal\Entities;

use App\Models\Empresa;
use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class LivroFiscal extends Model
{
    use SoftDeletes;
    use LogsActivity;
    use HasArquivos;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $table = 'livro_fiscal';

    protected $fillable = [
        'empresa_id',
        'ano',
        'status',
        'observacao',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
