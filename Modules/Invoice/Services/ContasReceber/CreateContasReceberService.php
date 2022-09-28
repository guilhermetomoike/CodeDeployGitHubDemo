<?php

namespace Modules\Invoice\Services\ContasReceber;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Payer\PayerContract;
use App\Repositories\CrmRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\Invoice\Entities\ContasReceber;
use Modules\Invoice\Repositories\ContasReceberRepository;

class CreateContasReceberService
{
    private CrmRepository $crmRepository;
    private ContasReceberRepository $contasReceberRepository;

    public function __construct(
        CrmRepository $crmRepository,
        ContasReceberRepository $contasReceberRepository
    )
    {
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
           $re = ContasReceber::where('payer_id',$payer->id)->where('vencimento',Carbon::now()->addMonths(1)->format('Y-m-20'))->first();
            if(!isset($re->id)){
            $this->contasReceberRepository->createContasReceber([
                'vencimento' => Carbon::now()->addMonths(1)->format('Y-m-20'),
                'valor' => (float)$valor,
                'descricao' => 'Honorário mensal',
                'payer_type' => $payer->getModelAlias(),
                'payer_id' => $payer->id,
            ]);
        }
        } else {
            $startDate = Carbon::parse($startDate);

            if ($startDate->isBefore(today())) {
                $startDate->setDateFrom(today());
            }
         
            // foreach ($this->makePeriod($startDate) as $date) {
                $date = $startDate->day > 20 ? $startDate->addMonth(1)->format('Y-m-20') : $startDate->format('Y-m-20');
                $this->contasReceberRepository->createContasReceber([
                    'vencimento' => $date,
                    'valor' => (float)$valor,
                    'descricao' => 'Honorário mensal',
                    'payer_type' => $payer->getModelAlias(),
                    'payer_id' => $payer->id,
                ]);
             
        }

    }

    private function makePeriod($startDate)
    {
        $startDate = Carbon::parse($startDate);

        if ($startDate->isBefore(today())) {
            $startDate->setDateFrom(today());
        }

        $from = $startDate->day > 20 ? $startDate->addMonth(1)->format('Y-m-20') : $startDate->format('Y-m-20');
        $to = Carbon::parse($from)->addMonths(1)->format('Y-m-20');
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
