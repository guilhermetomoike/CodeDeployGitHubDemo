<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Models\Empresa;
use App\Models\GuiaLiberacao;
use App\Services\Chart\IDataSetBuilderService;

class TaxesStatsService implements IDataSetBuilderService
{
    public function buildDataset(?array $params): ?iterable
    {
        $competencia = $params['competencia'] ?? competencia_anterior();
        if(isset($params['carteira'])){
        $cateiras = $params['carteira'];
        return $this->getForCarteira($competencia,$cateiras);

        }
        return $this->getMonthlyTaxesStats($competencia);

    }
    public function getForCarteira(string $competencia,$cateiras)
{
    $enviado = Empresa::withTrashed()
        
    ->with('carteirasrel')->whereHas('carteirasrel', function ($query) use($cateiras){ $query->where('carteiras.id',$cateiras);})
    ->where(['congelada' => 0, 'saiu' => 0])
        ->whereHas('guias', fn($guias) => $guias->where('data_competencia', $competencia))
        ->whereHas('guia_liberacao', function ($query) use ($competencia) {
            $query->where('competencia', $competencia);
            $query->where(function ($where) {
                $where->whereNotNull('data_envio');
                $where->orWhere('sem_guia');
            });
        })->count();

    $nao_enviado = Empresa::query()
  
    ->with('carteirasrel')->whereHas('carteirasrel', function ($query) use($cateiras){ $query->where('carteiras.id',$cateiras);})
        ->where(['congelada' => 0, 'saiu' => 0])
        ->whereIn('status_id', [100,99,80,70])
        ->where(function ($builder) use ($competencia) {
            $builder
                ->whereHas('guia_liberacao', function ($query) use ($competencia) {
                    $query->where('competencia', $competencia);
                    $query->whereNull('data_envio');
                })
                ->orWhereDoesntHave('guia_liberacao', function ($query) use ($competencia) {
                    $query->where('competencia', $competencia);
                });
        })->count();

    $sem_guias = GuiaLiberacao::query()
    ->with('empresa')->whereHas('empresa', fn ($query) => $query->with('carteirasrel')->whereHas('carteirasrel', function ($query) use($cateiras){ $query->where('carteiras.id',$cateiras);}))
        ->where('competencia', $competencia)
        ->where('sem_guia', true)
        ->where('rh_departamento_liberacao', true)
        ->where('financeiro_departamento_liberacao', true)
        ->where('contabilidade_departamento_liberacao', true)
        ->whereDoesntHave('guias', fn($guias) => $guias->where('data_competencia', $competencia))
        ->count();

    return [
        'enviado' => $enviado,
        'aguardando' => $nao_enviado - $sem_guias,
        'sem_guia' => $sem_guias,
    ];

}

    public function getMonthlyTaxesStats(string $competencia)
    {
        $enviado = Empresa::withTrashed()
        
            ->whereHas('guias', fn($guias) => $guias->where('data_competencia', $competencia))
            ->whereHas('guia_liberacao', function ($query) use ($competencia) {
                $query->where('competencia', $competencia);
                $query->where(function ($where) {
                    $where->whereNotNull('data_envio');
                    $where->orWhere('sem_guia');
                });
            })->count();

        $nao_enviado = Empresa::query()
      
            ->where(['congelada' => 0, 'saiu' => 0])
            ->whereNotIn('status_id', [1, 2, 3, 4, 9, 71, 81])
            ->where(function ($builder) use ($competencia) {
                $builder
                    ->whereHas('guia_liberacao', function ($query) use ($competencia) {
                        $query->where('competencia', $competencia);
                        $query->whereNull('data_envio');
                    })
                    ->orWhereDoesntHave('guia_liberacao', function ($query) use ($competencia) {
                        $query->where('competencia', $competencia);
                    });
            })->count();

        $sem_guias = GuiaLiberacao::query()
            ->where('competencia', $competencia)
            ->where('sem_guia', true)
            ->where('rh_departamento_liberacao', true)
            ->where('financeiro_departamento_liberacao', true)
            ->where('contabilidade_departamento_liberacao', true)
            ->whereDoesntHave('guias', fn($guias) => $guias->where('data_competencia', $competencia))
            ->count();

        return [
            'enviado' => $enviado,
            'aguardando' => $nao_enviado - $sem_guias,
            'sem_guia' => $sem_guias,
        ];
    }
}
