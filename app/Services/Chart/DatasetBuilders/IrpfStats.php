<?php

namespace App\Services\Chart\DatasetBuilders;

use App\Models\Cliente;
use App\Services\Chart\IDataSetBuilderService;
use Modules\Irpf\Services\IrpfService;

class IrpfStats implements IDataSetBuilderService
{
    private IrpfService $irpfService;

    public function __construct(IrpfService $irpfService)
    {
        $this->irpfService = $irpfService;
    }

    public function buildDataset(?array $params): ?iterable
    {
        return $this->queryIrpfStats();
    }

    private function queryIrpfStats(): array
    {
        return Cliente
            ::with([
                'irpf' => function ($query) {
                    $query->where('ano', today()->subYear()->year);
                },
                'irpf.resposta.pendencia',
                'irpf.pendencias',
            ])
            ->get()
            ->map(function ($customer) {
                $irpf = $customer->irpf;
                if (isset($irpf)) {
                    if ($irpf->cancelado === 1) return 'cancelados';
                }
                if (!$irpf || $irpf->step === 'questionario') return 'nao_responderam';
                if ($irpf->step === 'comprovante') return 'enviou_pendencias';
                if ($irpf->enviado) return 'finalizou';

                $pendenciesStatus = $this->irpfService->pendenciesStatus($irpf);
                if ($irpf->step === 'pendencia' && !$pendenciesStatus['sent']->count()) return 'responderam';
                if ($irpf->step === 'pendencia' && $pendenciesStatus['sent']->count() > 0) return 'iniciou_pendencias';

                return 'desconhecido';
            })
            ->groupBy(fn ($value) => $value)
            ->map(fn ($value) => count($value))
            ->toArray();
    }
}
