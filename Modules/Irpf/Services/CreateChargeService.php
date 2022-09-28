<?php

namespace Modules\Irpf\Services;

use App\Models\Payer\PayerContract;
use App\Services\Recebimento\Contracts\Recebimento;
use Modules\Invoice\Services\FaturaService;
use Modules\Irpf\Services\Contracts\CreateChargeInterface;

class CreateChargeService implements CreateChargeInterface
{
    private Recebimento $recebimento;
    private FaturaService $faturaService;

    public function __construct(Recebimento $recebimento, FaturaService $faturaService)
    {
        $this->recebimento = $recebimento;
        $this->faturaService = $faturaService;
    }

    public function createCharge(array $data, PayerContract $payer)
    {
        $faturaStructure = $this->qualifyStructureForFaturaService($data, $payer);
        $fatura = $this->faturaService->create($faturaStructure);

        try {
            return $this->recebimento->criarFaturaWithItems($fatura);
        } catch (\Exception $e) {
            $fatura->delete();
            throw new \Exception($e->getMessage());
        }
    }

    private function qualifyStructureForFaturaService(array $data, PayerContract $payer): array
    {
        return [
            'items' => collect($data)->transform(
                fn(IrpfChargeObject $item) => ($item->toArray())
            )->toArray(),
            'payer_type' => $payer->getModelAlias(),
            'payer_id' => $payer->id,
            'forma_pagamento_id' => 1,
            'data_vencimento' => today()->addDays(5)->toDateString()
        ];
    }
}
