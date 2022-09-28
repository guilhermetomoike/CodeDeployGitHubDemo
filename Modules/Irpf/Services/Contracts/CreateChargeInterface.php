<?php


namespace Modules\Irpf\Services\Contracts;


use App\Models\Payer\PayerContract;
use Modules\Irpf\Services\IrpfChargeObject;

interface CreateChargeInterface
{
    /**
     * @param IrpfChargeObject[] $data
     * @param PayerContract $payer
     * @return mixed
     */
    public function createCharge(array $data, PayerContract $payer);
}
