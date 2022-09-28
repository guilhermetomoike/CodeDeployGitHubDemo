<?php

namespace Modules\Invoice\Services;

use App\Models\Empresa;
use Modules\Invoice\Repositories\RotinasFinanRepository;
use Modules\Invoice\Services\ContasReceber\CreateMovimentacaoService;

class CreateAdicionaisService
{
    private CreateMovimentacaoService $movimentacaoService;

    public function __construct(
        CreateMovimentacaoService $movimentacaoService
    ) {
        $this->movimentacaoService = $movimentacaoService;
    }

    public function execute($data)
    {
        foreach ($data['adicionalFaturamento'] as $fat) {
            if (isset($fat->faturamentoAdicionais->faturamento)) {
                if (isset($fat->contas_receber->id)) {
                    $contador = 0;
                    $fatur = $fat->faturamentoAdicionais->faturamento;
                    while ($fatur >= 40000) {
                        $fatur =  $fatur - 40000;
                        $contador++;
                    }
                    if ($contador > 0) {


                        $this->movimentacaoService->createMovimentAddicionais(['contaReceberId' => $fat->contas_receber->id, 'valor' => 178 * $contador, 'descricao' => 'Adicional Faturamento']);
                    }
                }
            }
        }

        foreach ($data['adicionalSocios'] as $socio) {
            if (count($socio->sociosadicionais) > 0) {
                if (isset($socio->contas_receber->id)) {
                    $this->movimentacaoService->createMovimentAddicionais(['contaReceberId' => $socio->contas_receber->id, 'valor' => (count($socio->sociosadicionais) - 2) * 40, 'descricao' => 'Adicional Socios']);
                }
            }
        }

        foreach ($data['adicionalFuncionarios'] as $fun) {
            if (isset($fun->funcionarios[0]->id)) {
                if (isset($fun->contas_receber->id)) {
                    $this->movimentacaoService->createMovimentAddicionais($a[] = ['contaReceberId' => $fun->contas_receber->id, 'valor' => count($fun->funcionarios) * 70, 'descricao' => 'Adicional Funcionarios']);
                }
            }
        }

      
    }
}
