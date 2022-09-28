<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'setor', 'responsavel_id'];
    protected $with = ['responsavel'];

    public static function getEmpresasIdFromCarteira(int $carteira_id)
    {
        $carteira = self::query()->find($carteira_id);
        if (!$carteira) return [];

        $empresas = $carteira->empresas;
        if (!$empresas) return [];

        return $empresas->pluck('id');
    }

    public function responsavel()
    {
        return $this->belongsTo(Usuario::class, 'responsavel_id')->withTrashed();
    }

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'carteira_empresa');
    }
}
