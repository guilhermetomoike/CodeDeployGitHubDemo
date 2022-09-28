<?php


namespace Modules\Irpf\Services\Contracts;


use Modules\Irpf\Entities\DeclaracaoIrpf;
use Modules\Irpf\Services\IrpfChargeObject;

interface CalculateChargesInterface
{
    public function setDeclaracaoIrpf(DeclaracaoIrpf $declaracaoIrpf);

    public function execute(): array;
}
