<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use App\Models\GuiaLiberacao;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class LiberaFinanceiroCommand extends Command
{
    protected $signature = 'liberacao:financeiro';

    protected $description = 'Libera envio de guias empresas sem cobranca e pag cartao';

    public function handle()
    {
        $empresas = $this->getEmpresas();

        $empresas->each(function ($empresa) {
            GuiaLiberacao::query()->updateOrCreate([
                'empresa_id' => $empresa->id,
                'competencia' => competencia_anterior()
            ], ['financeiro_departamento_liberacao' => true]);
        });
    }

    protected function getEmpresas()
    {
        $empresas = Empresa::query()
            ->select('id')
            ->where('congelada', 0)
            ->where('status_id', 100)
            ->whereHas('guia_liberacao', function (Builder $guiaLibeacao) {
                $guiaLibeacao->where('competencia', competencia_anterior());
                $guiaLibeacao->where('financeiro_departamento_liberacao', false);
            })
            ->where(function (Builder $where) {
                $where->whereDoesntHave('plans', function ($plan) {
                    $plan->where('price', '>', 0);
                });
            })
            ->get();

        return $empresas;
    }
}
