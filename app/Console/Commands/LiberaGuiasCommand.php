<?php

namespace App\Console\Commands;

use App\Services\GuiaService;
use Illuminate\Console\Command;

class LiberaGuiasCommand extends Command
{
    protected $signature = 'liberacao:guia';

    protected $description = 'Libera guias para envio por departamento que ja possui anexos';

    public function handle(GuiaService $guiaService)
    {
        $guiaService->eligesToSend();
        $guiaService->eligesWithouTaxes();
    }
}
