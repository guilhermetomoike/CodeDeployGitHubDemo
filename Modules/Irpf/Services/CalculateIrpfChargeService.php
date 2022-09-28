<?php

namespace Modules\Irpf\Services;

use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Services\Contracts\CalculateChargesInterface;

class CalculateIrpfChargeService implements CalculateChargesInterface
{
    private DeclaracaoIrpf $declaracaoIrpf;

    public function setDeclaracaoIrpf(DeclaracaoIrpf $declaracaoIrpf): CalculateIrpfChargeService
    {
        $this->declaracaoIrpf = $declaracaoIrpf;
        return $this;
    }

    /**
     * @return IrpfChargeObject[]
     */
    public function execute(): array
    {
        $irpfCharge[] = $this->calculateLancamentos();
        if ($this->declaracaoIrpf->rural) {
            $irpfCharge[] = $this->includeRuralCharge();
        }
        if ($this->declaracaoIrpf->ganho_captal) {
            $irpfCharge[] = $this->includeGanhoCaptalCharge();
        }
        return $irpfCharge;
    }

    private function calculateLancamentos(): IrpfChargeObject
    {
        if ($this->declaracaoIrpf->qtd_lancamento > 5) {
            $qtdExtra = $this->declaracaoIrpf->qtd_lancamento - 5;
            $valor_extra = $qtdExtra * config('irpf.charges.price_extra_entry');
            $valor_total = $valor_extra + config('irpf.charges.price_up_to_5_entry');

            return IrpfChargeObject::create()
                ->setDescricao($this->declaracaoIrpf->qtd_lancamento . ' Lançamentos')
                ->setValor($valor_total)
                ->setQtd(1);
        }

        return IrpfChargeObject::create()
            ->setDescricao('Lançamentos')
            ->setValor(config('irpf.charges.price_up_to_5_entry'))
            ->setQtd(1);
    }

    private function includeRuralCharge(): IrpfChargeObject
    {
        return IrpfChargeObject::create()
            ->setDescricao('Rural')
            ->setValor(config('irpf.charges.price_rural'))
            ->setQtd(1);
    }

    private function includeGanhoCaptalCharge()
    {
        return IrpfChargeObject::create()
            ->setDescricao('Ganho de Captal')
            ->setValor(config('irpf.charges.price_ganho_captal'))
            ->setQtd(1);
    }
}
