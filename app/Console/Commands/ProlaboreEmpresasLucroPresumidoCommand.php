<?php

namespace App\Console\Commands;

use App\Jobs\ProlaboreEmpresasLucroPresumidoJob;
use Illuminate\Console\Command;

class ProlaboreEmpresasLucroPresumidoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prolabore:presumido';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria receitas para todas as empresas com lucro presumido.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ProlaboreEmpresasLucroPresumidoJob::dispatch();
    }
}
