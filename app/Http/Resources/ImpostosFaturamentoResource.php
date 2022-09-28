<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImpostosFaturamentoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $ultimo_faturamento = $this->resource->first()['faturamento'];
        $ultimo_imposto = $this->resource->first()['impostos'];
        $mes = date_for_human($this->resource->first()['data_competencia'], '%b de %Y');
        $faturamento_liquido_mes = max(($ultimo_faturamento - $ultimo_imposto), 0);

        $total_impostos = $this->resource->sum('impostos');
        $total_faturamento = $this->resource->sum('faturamento');
        $competencia_trimestre = $this->resource->map(function ($mes) {
            $date = date_for_human($mes['data_competencia'], '%b de %Y');
            return ucfirst($date);
        })->toArray();
        $total_faturamento_liquido = max($total_faturamento - $total_impostos, 0);

        return [
            'mes' => [
                'data_competencia' => ucfirst($mes),
                'faturamento' => $faturamento_liquido_mes,
                'impostos' => $ultimo_imposto,
            ],
            'trimestre' => [
                'data_competencia' => end($competencia_trimestre) . ' - ' . $competencia_trimestre[0],
                'trimestre' => $this->resource[0]['trimestre'] . 'º Trimestre',
                'faturamento' => $total_faturamento_liquido,
                'impostos' => $total_impostos
            ],
        ];
    }
}
