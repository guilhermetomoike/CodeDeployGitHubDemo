<?php

namespace Modules\Invoice\Jobs;

use App\Models\Faturamento;
use Modules\Invoice\Entities\ContasReceber;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Invoice\Services\CreateEmpresafaturamentoService;

class CreateFaturamentoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private  $faturamento;

    public function __construct($faturamento)
    {
       
        $this->faturamento = $faturamento;
    }
  
    public function handle(CreateEmpresafaturamentoService $createInvoiceService)
    {
        $createInvoiceService->create($this->faturamento);
      
    }
}
