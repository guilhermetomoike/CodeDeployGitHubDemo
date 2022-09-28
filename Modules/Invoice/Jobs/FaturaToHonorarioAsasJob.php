<?php

namespace Modules\Invoice\Jobs;

use Modules\Invoice\Entities\Fatura;
use App\Services\GuiaService;
use App\Services\Recebimento\Gatway\Asas\AsasService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FaturaToHonorarioAsasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fatura;
    private $tipo;

    public function __construct(Fatura $fatura, $tipo = null)
    {
        $this->fatura = $fatura;
        $this->tipo = $tipo;
        $this->onQueue('financeiro');
    }

    public function handle(AsasService $asasService, GuiaService $guiaService)
    {
        if ($this->tipo != 1) {
            return;
        }
   
        // if (!$this->fatura->payer->cartao_credito->count()) {
          $arquivo =  $asasService->downloadPdf($this->fatura);
            $guiaService->createOrUpdateHonorario($arquivo,$this->fatura);
        // }

        $guiaService->changeLiberacao(
            ['financeiro_departamento_liberacao' => true],
            $this->fatura->payer_id,
            $this->fatura->data_competencia
        );
        sleep(2);
    }
}
