<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimulacaoPgblByEmpresaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'com_pgbl' => [
                'renda_anual' => formata_moeda($this['renda_anual_c'], true),
                'retido' => formata_moeda($this['retido'], true),
                'inss' => formata_moeda($this['inss'], true),
                'devido' => formata_moeda($this['devido_c'], true),
                'pagar' => formata_moeda($this['pagar_c'], true),
            ],
            'sem_pgbl' => [
                'renda_anual' => formata_moeda($this['renda_anual_s'], true),
                'retido' => formata_moeda($this['retido'], true),
                'inss' => formata_moeda($this['inss'], true),
                'devido' => formata_moeda($this['devido_s'], true),
                'pagar' => formata_moeda($this['pagar_s'], true),
            ],
            'resumo' => [
                'valor_aplicado' => formata_moeda($this['valor_aplicado'], true),
                'economia' => formata_moeda($this['economia'], true),
            ],
        ];
    }
}
