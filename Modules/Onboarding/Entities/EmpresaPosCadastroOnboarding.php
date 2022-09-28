<?php

namespace Modules\Onboarding\Entities;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Model;

class EmpresaPosCadastroOnboarding extends Model
{
    protected $fillable = ['nome', 'completo', 'empresa_id'];

    protected $casts = [
        'completo' => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
