<?php

namespace Modules\Invoice\Services\ContasReceber;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Payer\PayerContract;
use App\Repositories\CrmRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\Invoice\Repositories\ContasReceberRepository;
use Modules\Invoice\Entities\ContasReceber;

class CreateContasReceberVeryService
{
    private CrmRepository $crmRepository;
    private ContasReceberRepository $contasReceberRepository;

    public function __construct(
        CrmRepository $crmRepository,
        ContasReceberRepository $contasReceberRepository
    ) {
        $this->crmRepository = $crmRepository;
        $this->contasReceberRepository = $contasReceberRepository;
    }

    public function createContasReceberByPayer(PayerContract $payer, bool $unique)
    {

        $startDate = null;

        if (!$this->validatePayer($payer)) {
            return null;
        }


        if ($payer instanceof Empresa) {
            $crm = $this->crmRepository->getCrmAppropriatedForBillingByEmpresa($payer);
            $startDate = $crm->data_emissao ?? null;

            $preCadastro = $payer->precadastro ?? null;
            if (
                $preCadastro &&
                $preCadastro->data_inicio_cobranca &&
                $preCadastro->tipo === 'transferencia' &&
                Carbon::parse($preCadastro->data_inicio_cobranca)->isAfter(today())
            ) {
                return null;
            }
        }

        $valor = $payer->plans()->sum('price');
        if (!$valor) {
            return null;
        }

        if ($unique) {
        } else {
            $contasReceber = ContasReceber
                ::where('payer_id', $payer->id)
                ->whereDate('vencimento', '>=', $startDate)
                ->whereNull('consumed_at')

                // ->with('cliente', 'empresa')
                ->get();
           

            foreach ($this->makePeriod($startDate) as $date) {
             
                if (count($contasReceber)>=1) {
                    $count = 0;
                    foreach ($contasReceber as $contareceber) {
                     

                        if ($date->format('Y-m-15') == $contareceber->vencimento) {
                           $count++;

                        }
                      
                    }
            
                    if($count==0){
                        $this->contasReceberRepository->createContasReceber([
                            'vencimento' => $date->format('Y-m-15'),
                            'valor' => (float)$valor,
                            'descricao' => 'Honorário mensal',
                            'payer_type' => $payer->getModelAlias(),
                            'payer_id' => $payer->id,
                        ]);
                        $count = 0;
                    }

                } 
                if (count($contasReceber) == 0) { 
                    $this->contasReceberRepository->createContasReceber([
                        'vencimento' => $date->format('Y-m-15'),
                        'valor' => (float)$valor,
                        'descricao' => 'Honorário mensal',
                        'payer_type' => $payer->getModelAlias(),
                        'payer_id' => $payer->id,
                    ]);
                }
            }
        }
    }

    private function makePeriod($startDate)
    {
        $startDate = Carbon::parse($startDate);

        if ($startDate->isBefore(today())) {
            $startDate->setDateFrom(today());
        }

        $from = $startDate->day > 15 ? $startDate->addMonth()->format('Y-m-15') : $startDate->format('Y-m-15');
        $to = Carbon::parse($from)->addMonths(5)->format('Y-m-15');
        return new CarbonPeriod($from, '1 month', $to);
    }

    private function validatePayer(PayerContract $payer)
    {
        if ($payer instanceof Cliente) {
            return true;
        }

        if (!$payer->alvara()->count()) {
            return false;
        }

        $crm = $this->crmRepository->getCrmAppropriatedForBillingByEmpresa($payer);
        if (!$crm || !$crm->data_emissao) {
            return false;
        }

        return true;
    }
}
