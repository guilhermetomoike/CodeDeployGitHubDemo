<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Models\Cliente;
use App\Models\Empresa;
use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Database\Eloquent\Collection;

class PaymentDefaulterService implements IDataSetBuilderService
{
    public function buildDataset($params = []): ?iterable
    {
        $defaulting = $this->getDefaulters();
        return $this->qualifyDataSet($defaulting);
    }

    private function getDefaulters()
    {
        $data1 = Empresa::query()
            ->with(['fatura' => function ($fatura) {
                $fatura->whereNull('data_recebimento');
                $fatura->whereNotIn('status', ['pago', 'cancelado', 'pendente']);
            }])
            ->whereHas('fatura', function ($fatura) {
                $fatura->whereNull('data_recebimento');
                $fatura->whereNotIn('status', ['pago', 'cancelado', 'pendente']);
            })
            ->get();

        $data2 = Cliente::query()
            ->with(['fatura' => function ($fatura) {
                $fatura->whereNull('data_recebimento');
                $fatura->whereNotIn('status', ['pago', 'cancelado', 'pendente']);
            }])
            ->whereHas('fatura', function ($fatura) {
                $fatura->whereNull('data_recebimento');
                $fatura->whereNotIn('status', ['pago', 'cancelado', 'pendente']);
            })
            ->get();

        return $data1->merge($data2);
    }

    private function qualifyDataSet(Collection $defaulting)
    {
        return $defaulting->transform(function ($defaulter) {
            $invoices = $defaulter->fatura
                ->whereNull('data_recebimento')
                ->whereNotIn('status', ['pago', 'cancelado', 'pendente']);
            return [
                'id' => $defaulter->id,
                'type' => $defaulter instanceof Cliente ? 'cliente' : 'empresa',
                'name' => $defaulter->razao_social ?? $defaulter->nome_completo,
                'subtotal' => $invoices->sum('subtotal'),
                'qtd' => $invoices->count(),
            ];
        });
    }
}
