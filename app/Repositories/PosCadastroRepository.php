<?php

namespace App\Repositories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PosCadastroRepository
{
    public function getPosCadastroList(array $data)
    {
        return Empresa::query()
            ->with(['precadastro', 'socioAdministrador:nome_completo'])
            ->whereBetween('status_id', [1, 99])
            ->whereNotIn('status_id', [70, 71, 80, 81])
            ->when($data['status_id'], function (Builder $query, $status_id) {
                $query->whereIn('status_id', is_array($status_id) ? $status_id : [$status_id]);
            })
            ->when($data['tipo'], function (Builder $query, $tipo) {
                $query->whereHas('precadastro', function (Builder $query) use ($tipo) {
                    $query->where('tipo', $tipo);
                });
            })
            ->orderBy('id')
            ->get();
    }

    public function loadCompleteEmpresaPosCadastro(int $id)
    {
        return Empresa::with([
            'precadastro',
            'arquivos',
            'contatos',
            'endereco',
            'cnae',
            'socios' => fn(BelongsToMany $socio) => $socio->with([
                'arquivos',
                'estado_civil',
                'profissao',
                'crm' => fn($crm) => $crm->with('arquivo'),
                'irpf' => fn($irpf) => $irpf->where('ano', today()->subYear()->year)->with('arquivos'),
                'certificado_digital' => fn($certificado) => $certificado->with('arquivos')
            ]),
            'acessos_prefeituras' => fn(HasMany $acessos) => ($acessos->where('tipo', Empresa\AcessoPrefeitura::EMISSOR)),
        ])->find($id);
    }

    public function getCompanyWithContractNotSignedBy(int $count_days)
    {
        return Empresa::query()
            ->whereIn('status_id', [1, 2])
            ->whereHas('contrato', function ($contrato) {
                $contrato->whereNull('signed_at');
            })
            ->whereHas('precadastro')
            ->whereDate('created_at', today()->subDays($count_days)->toDateString())
            ->get();
    }
}
