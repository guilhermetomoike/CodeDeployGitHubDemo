<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EmpresaPreCadastro extends Model
{
    use SoftDeletes, HasArquivos, LogsActivity;

    protected static $logAttributes = ['*'];

    protected $fillable = ['tipo', 'usuario_id', 'empresa', 'empresa->protocolo', 'responsavel_onboarding_id', 'data_inicio_cobranca'];

    protected $casts = ['empresa' => 'array'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function usuarioOnboarding()
    {
        return $this->belongsTo(Usuario::class, 'responsavel_onboarding_id', 'id');
    }
}
