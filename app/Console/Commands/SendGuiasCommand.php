<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Services\GuiaService;
use Illuminate\Console\Command;

class SendGuiasCommand extends Command
{
    protected $signature = 'send:guias {--retry}';
    protected $description = 'Envia guias das empresas prontas pra envio';

    public function handle(GuiaService $guiaService)
    {
        if (!Schedule::getBySlug('send-guias')->is_active) return;

        $competencia = today()->firstOfMonth()->subMonths(1)->format('Y-m-d');
        $shouldRetry = $this->option('retry');
        $guiaService->sendAllGuiasEligibles($competencia, $shouldRetry);
    }
}
