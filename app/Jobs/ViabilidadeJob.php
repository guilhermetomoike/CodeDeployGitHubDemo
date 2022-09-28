<?php

namespace App\Jobs;

use App\Models\ViabilidadeMunicipal;
use App\Services\OrdemServico\OrdemServicoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ViabilidadeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ViabilidadeMunicipal $viabilidadeMunicipal;

    public function __construct(ViabilidadeMunicipal $viabilidadeMunicipal)
    {
        $this->viabilidadeMunicipal = $viabilidadeMunicipal;
    }

    public function handle(OrdemServicoService $ordemServicoService)
    {
        $ordemServicoService->storeOrdemServico($this->osDataProvider());
    }

    private function osDataProvider() {
        $cidadeNome = $this->viabilidadeMunicipal->cidade->nome.' - '.$this->viabilidadeMunicipal->cidade->estado->uf;
        return [
            'empresa_id' => 200,
            'os_base' => [
                [
                    'os_base_id' => 11,
                    'data_limite' => today()->addWeek()->toDateString()
                ]
            ],
            'descricao' => 'Renovar viabilidade municipal da cidade '.$cidadeNome
        ];
    }
}
