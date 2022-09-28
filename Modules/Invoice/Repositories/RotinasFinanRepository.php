<?php

namespace Modules\Invoice\Repositories;

use App\Models\Empresa;
use Modules\Invoice\Services\CreateAdicionaisService;

class RotinasFinanRepository
{

    private CreateAdicionaisService $createAdicionaisService;

    public function __construct(CreateAdicionaisService $createAdicionaisService)
    {
        $this->createAdicionaisService = $createAdicionaisService;
    }

    public function createAdicionaisContasReceber()
    {
        $data['adicionalFaturamento']   = Empresa::with('faturamentoAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)
        );

        $data['adicionalSocios']  = Empresa::with('sociosAdicionais', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->sociosAdicionais) > 2
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)
        );

        $data['adicionalFuncionarios'] = Empresa::with('funcionarios', 'contas_receber')->select('id', 'nome_empresa', 'cnpj')->get()->filter(
            fn ($empresa) =>
            !$empresa->congelada &&
                $empresa->status_id !== 81 &&
                count($empresa->funcionarios) > 0 &&
                $empresa->id !== 200
                && isset($empresa->contrato->extra['clicksign'])
                && isset($empresa->contrato->arquivos[0]->id)
        );

          $this->createAdicionaisService->execute($data);
    }
}
