<?php

namespace App\Console\Commands;

use App\Jobs\ViabilidadeJob;
use App\Repositories\ViabilidadeRepository;
use Illuminate\Console\Command;

class ViabilidadeCommand extends Command
{
    protected $signature = 'viabilidade:renovar';

    protected $description = 'Cria OS para renovação da viabilidade';

    public function handle(ViabilidadeRepository $viabilidadeRepository)
    {
        $updated_at = today()->subMonth()->toDateString();
        $viabilidades = $viabilidadeRepository->getFromUpdatedAt($updated_at);

        foreach ($viabilidades as $viabilidade) {
            ViabilidadeJob::dispatch($viabilidade);
        }
    }
}
