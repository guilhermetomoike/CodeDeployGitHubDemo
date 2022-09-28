<?php

namespace App\Console\Commands;

use App\Jobs\EmitirNfseJob;
use Illuminate\Console\Command;
use Modules\Invoice\Entities\Fatura;

class EmitirNfseCommand extends Command
{
    protected $signature = 'emitir-nfse {competencia?}';
    protected $description = 'Rodar comando de emissao de notas fiscais de faturas pagas.';

    public function handle()
    {
        $competencia = $this->argument('competencia') ?? competencia_anterior();
        $today = now();

        $faturas = Fatura
            ::query()
            ->whereDoesntHaveMorph('payer', ['*'], function ($query) use($today) {
                $query->whereHas('nfse', function ($query) use($today) {
                    $query
                        ->where(function ($query) use($today) {
                            $query
                                ->where('status', 'CONCLUIDO')
                                ->whereMonth('emissao', $today->month)
                                ->whereYear('emissao',  $today->year);
                        })
                        ->orWhere(function ($query) use($today) {
                            $query
                                ->where('status', 'PROCESSANDO')
                                ->whereMonth('created_at', $today->month)
                                ->whereYear('created_at',  $today->year);
                        });
                });
            })
            ->where('status', 'pago')
            ->whereMonth('data_recebimento', $today->month)
            ->whereYear('data_recebimento',  $today->year)
            ->get();

        $faturas->each(function ($fatura) use ($competencia) {
            EmitirNfseJob::dispatch($fatura, $competencia);
        });
    }
}
