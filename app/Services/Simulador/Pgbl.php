<?php


namespace App\Services\Simulador;

use App\Models\TabelaIr;
use App\Services\Simulador\Pgbl\SimulatorPgbl;
use Illuminate\Support\Collection;

class Pgbl implements SimulatorPgbl
{
    public function simulate(Collection $prolabores)
    {
        $percentual_aplicado = 12;

        if ($prolabores->count() === 0) {
            return false;
        }

        $rendaTotalAnual = $prolabores->sum('prolabore');
        $total_irrf = $prolabores->sum('irrf');
        $total_inss = $prolabores->sum('inss');

        $rendaAnual = $prolabores->groupBy('data_competencia')->map(function ($prolabore) use (&$inss_deduzido) {
            $inss_mes = $prolabore->sum('inss');
            $prolabore_mes = $prolabore->sum('prolabore');
            $inss = min($inss_mes, 671.11);
            $inss_deduzido[] = $inss;
            return $prolabore_mes - $inss;
        })->sum();

        $total_inss_deduzido = array_sum($inss_deduzido);

        $valor_pgbl = ($rendaTotalAnual * $percentual_aplicado) / 100;

        $imposto_devido_sem_pgbl = $this->impostoDevido($rendaAnual);
        $total_devido_sem_pgbl = $this->impostoAPagar($total_irrf, $imposto_devido_sem_pgbl);

        $imposto_devido_com_pgbl = $this->impostoDevido($rendaAnual - $valor_pgbl);
        $total_devido_com_pgbl = $this->impostoAPagar($total_irrf, $imposto_devido_com_pgbl);

        $result = [
            'renda_anual_c' => $rendaTotalAnual - $valor_pgbl,
            'devido_c' => $imposto_devido_com_pgbl,
            'pagar_c' => $total_devido_com_pgbl,

            'retido' => $total_irrf,
            'inss' => $total_inss_deduzido,

            'renda_anual_s' => $rendaTotalAnual,
            'devido_s' => $imposto_devido_sem_pgbl,
            'pagar_s' => $total_devido_sem_pgbl,

            'valor_aplicado' => $valor_pgbl,
            'economia' => $total_devido_sem_pgbl - $total_devido_com_pgbl,
        ];

        return new Collection($result);
    }

    public function impostoDevido(float $rendaAnual): float
    {
        $faixa = TabelaIr::getFaixa($rendaAnual / 12);

        $imposto_devido = (($rendaAnual * $faixa->aliquota) / 100) - ($faixa->deducao * 12);

        return $imposto_devido;
    }

    public function impostoAPagar(float $total_irrf, float $imposto_devido): float
    {
        $total_imposto_a_pagar = $imposto_devido - $total_irrf;

        return $total_imposto_a_pagar;
    }
}
