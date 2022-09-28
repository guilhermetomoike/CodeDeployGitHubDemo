<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TabelaIr extends Model
{
    protected $table = 'tabela_ir';

    protected $fillable = [
        'base_calculo_from', 'base_calculo_to', 'aliquota', 'deducao'
    ];

    public static function getFaixa($faturamentoMedio)
    {
        $faixa = self::query()
            ->where('base_calculo_to', '>=', $faturamentoMedio)
            ->orderBy('base_calculo_to')
            ->first();

        if (!$faixa) {
            $faixa = self::query()
                ->orderBy('base_calculo_to')
                ->first();
        }

        return $faixa;
    }
}
