<?php


namespace App\Services\Simulador\Pgbl;

use Illuminate\Database\Eloquent\Collection;

interface SimulatorPgbl
{
    /**
     * Recebe uma colecao de prolabores e realiza a simulacao de impostos a pagar com e sem aplicação
     *
     * @param Collection $prolabores
     *
     * @return array
     */
    public function simulate(Collection $prolabores);

    /**
     * Recebe o total de irrf do ano e o total de impost devido sem deducao e retorna o valor final de imposto a pagar
     *
     * @param float $total_irrf
     *
     * @param float $imposto_devido
     *
     * @return float
     */
    public function impostoAPagar(float $total_irrf, float $imposto_devido) : float;

    /**
     * Recebe a o total da renda anual e retorna o total de imposto devido sem deducao
     *
     * @param float $rendaAnual
     *
     * @return float
     */
    public function impostoDevido(float $rendaAnual): float;

}