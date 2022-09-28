<?php


namespace App\Repositories;


use App\Models\Empresa;
use App\Models\GuiaLiberacao;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\JoinClause;

class GuialiberacaoRepository
{
    public function getByEmpresaIdWithGuias(int $empresa_id, string $competencia)
    {
        return GuiaLiberacao::query()
            ->where('empresa_id', $empresa_id)
            ->where('competencia', $competencia)
            ->where('rh_departamento_liberacao', true)
            ->where('contabilidade_departamento_liberacao', true)
            ->where('financeiro_departamento_liberacao', true)
            ->whereNotNull('data_envio')
            ->whereHas('guias', function (Builder $guia) use ($competencia) {
                $guia->where('data_competencia', $competencia);
            })
            ->with(['guias' => function (HasMany $guia) use ($competencia) {
                $guia->where('data_competencia', $competencia);
                $guia->with('arquivo');
            }])
            ->first();
    }

    public function getListEmpresasGuiasAndLiberacao(string $competencia, ?string $data_envio = null)
    {
        return Empresa::query()
            ->select('empresas.id', 'razao_social', 'regime_tributario')
            ->where(['saiu' => 0])
            ->whereNotIn('status_id', [1, 2, 3, 4, 9, 71])
//            ->whereHas('guia_liberacao', fn($liberacao) => $liberacao->where('competencia', $competencia))
//            ->whereHas('guias', fn($guias) => $guias->where('data_competencia', $competencia))
            ->when($data_envio, function ($query, $value) {
                $query->whereHas('guia_liberacao', function ($guia_liberacao) use ($value) {
                    $guia_liberacao->whereDate('data_envio', $value);
                });
            })
            ->with([
                'guias' => function (HasMany $guias) use ($competencia) {
                    $guias->with('arquivo');
                    $guias->where('data_competencia', $competencia);
                    $guias->where('estornado', false);
                },
                'guia_liberacao' => function (HasMany $guia_liberacao) use ($competencia) {
                    $guia_liberacao->where('competencia', $competencia);
                },
                'cartao_credito',
                'carteiras',
            ])
            ->get();
    }

    public function getGuiaLiberacaoDisponivelEnvio(string $competencia, bool $shouldRetryWithErros)
    {
        return GuiaLiberacao::query()
            ->where('competencia', $competencia)
            ->where('financeiro_departamento_liberacao', 1)
            ->where('rh_departamento_liberacao', 1)
            ->where('contabilidade_departamento_liberacao', 1)
            ->whereNull('data_envio')
            ->where('erro_envio', '<=', $shouldRetryWithErros)
            ->with('empresa')
            ->whereHas('empresa')
            ->whereHas('guias', function ($guias) use ($competencia) {
                $guias->where('data_competencia', $competencia);
            })
            ->get();
    }

    public function getEmpresasGuiasWithouEligibility(?string $data_competencia)
    {
        return Empresa::query()
            ->whereHas('guias', function (Builder $guia) use ($data_competencia) {
                $guia->where('data_competencia', $data_competencia);
            })
            ->with(['guias' => function (HasMany $guia) use ($data_competencia) {
                $guia->where('data_competencia', $data_competencia);
            }])
            ->whereDoesntHave('guia_liberacao', function (Builder $builder) use ($data_competencia) {
                $builder->where('competencia', $data_competencia);
                $builder->where('rh_departamento_liberacao', 1);
                $builder->where('financeiro_departamento_liberacao', 1);
                $builder->where('contabilidade_departamento_liberacao', 1);
            })
            ->get();
    }

    public function updateLiberacao(int $empresaId, string $dataCompetencia, array $liberacao)
    {
        return GuiaLiberacao::query()->updateOrCreate([
            'empresa_id' => $empresaId,
            'competencia' => $dataCompetencia
        ], $liberacao);
    }

    public function updateLiberationWithouTaxes(?string $competencia)
    {
        return GuiaLiberacao::query()
            ->where('competencia', $competencia)
            ->where('financeiro_departamento_liberacao', 1)
            ->where('rh_departamento_liberacao', 1)
            ->where('contabilidade_departamento_liberacao', 1)
            ->whereNull('data_envio')
            ->with('empresa')
            ->whereHas('empresa')
            ->whereDoesntHave('guias', function ($guias) use ($competencia) {
                $guias->where('data_competencia', $competencia);
            })
            ->update([
                'sem_guia' => true
            ]);
    }
}
