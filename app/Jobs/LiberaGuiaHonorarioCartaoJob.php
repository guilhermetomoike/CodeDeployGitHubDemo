<?php

namespace App\Jobs;

use App\Models\Contrato;
use App\Services\GuiaService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class LiberaGuiaHonorarioCartaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $empresa_id;
    private $competencia;

    public function __construct($empresa_id, $competencia = null)
    {
        $this->empresa_id = $empresa_id;
        $this->onQueue('financeiro');
        $this->competencia = $competencia;
    }

    public function tags()
    {
        return ['empresa:' . $this->empresa_id];
    }

    public function handle(GuiaService $guiaService)
    {
        $contrato = Contrato::query()->where('empresas_id', $this->empresa_id)->first();

        if ($contrato && $contrato->forma_pagamento_id === 2) {
            $guiaService->changeLiberacao(
                ['financeiro_departamento_liberacao' => true],
                $this->empresa_id,
                $this->competencia
            );
        }
    }
}
