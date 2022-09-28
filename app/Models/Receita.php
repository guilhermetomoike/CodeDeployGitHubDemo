<?php

namespace App\Models;

use App\Models\Traits\HasArquivos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receita extends Model
{
    use SoftDeletes, HasArquivos;

    protected $fillable = [
        'cliente_id',
        'empresa_id',
        'cnpj',
        'prolabore',
        'inss',
        'irrf',
        'fator_r',
        'data_competencia',
        'lancado',
    ];

    public static function getFilteredList(string $competencia, ?int $carteira_id, bool $filterLancados)
    {
        return self::query()
            ->with(['cliente', 'arquivo', 'empresa'])
            ->where('data_competencia', $competencia)
            ->when($filterLancados, function ($receitas, $filterLancados) {
                $receitas->where('lancado', false);
            })
            ->when($carteira_id, function ($receitas, $carteira_id) {
                $carteiraEmpresas = Carteira::getEmpresasIdFromCarteira($carteira_id);
                $receitas->whereIn('empresa_id', $carteiraEmpresas);
            })
            ->oldest()
            ->get();
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function findAddCompetenciaAnterior($competenciaAnterior)
    {
        $receitaAnterior = self::query()
            ->with('cliente')
            ->where('empresa_id', $this->empresa_id)
            ->where('cliente_id', $this->cliente_id)
            ->where('data_competencia', $competenciaAnterior->format('Y-m-d'))
            ->first();

        $this->competencia_anterior = $competenciaAnterior;
        $this->prolabore_anterior = $receitaAnterior ? $receitaAnterior->prolabore : 0;
        $this->anterior = $receitaAnterior;
        return $this;
    }
}
