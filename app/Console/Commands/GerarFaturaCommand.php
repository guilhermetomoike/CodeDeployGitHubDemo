<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use Illuminate\Console\Command;

class GerarFaturaCommand extends Command
{
    protected $signature = 'gerar:fatura {competencia?}';

    protected $description = 'Gera as faturas das empresas com base nos planos';

    public function handle()
    {
        $competencia = $this->argument('competencia') ?? competencia_anterior();
        $empresas = Empresa::query()
            ->where('saiu', 0)
            ->where('congelada', 0)
            ->whereNotNull('cnpj')
            ->whereRaw('empresas.id not in (SELECT empresas_id FROM empresas_planos WHERE planos_id = ?)', 20)
            ->whereRaw('empresas.id in (SELECT empresas_id FROM contratos WHERE teto_cobranca is not null)')
            ->get();

        $empresas->each(function (Empresa $empresa) use ($competencia) {
            GerarFaturaJob::dispatch($empresa, $competencia);
        });
    }
}
