<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Services\Chart\IDataSetBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MonthlyPaymentStatsService implements IDataSetBuilderService
{
    public function buildDataset($params): ?iterable
    {
        $date = $params['date'] ?? competencia_anterior();
        $invoices = $this->getInvoicesByMonth($date);
        return $this->qualifyDataSet($invoices);
    }

    private function getInvoicesByMonth(string $date): Collection
    {
        $date = Carbon::parse($date)->subMonth()->toDateString();
        $data = DB::select("SELECT fatura.subtotal,
       month(fatura.data_competencia) as 'month',
       year(fatura.data_competencia)  as 'year',
       fatura.data_vencimento,
       fatura.data_recebimento,
       fatura.status
        from fatura
        where month(fatura.data_competencia) = month(?)
          and year(fatura.data_competencia) = year(?)
          and status in ('pendente', 'processando', 'atrasado', 'pago')", [$date, $date]);
        return new Collection($data);
    }

    private function qualifyDataSet(Collection $invoicesByMonth)
    {
        $labels = ['Pago em dia', 'Pago em atraso', 'Pendente'];
        $pagoEmDia = $invoicesByMonth
            ->filter(fn($invoice) => $invoice->data_recebimento && $invoice->data_vencimento >= $invoice->data_recebimento)
            ->sum('subtotal');

        $pagoEmAtraso = $invoicesByMonth
            ->filter(fn($invoice) => $invoice->data_recebimento && $invoice->data_vencimento < $invoice->data_recebimento)
            ->sum('subtotal');

        $pendente = $invoicesByMonth
            ->filter(fn($invoice) => !$invoice->data_recebimento)
            ->sum('subtotal');

        return [
            'data' => [$pagoEmDia, $pagoEmAtraso, $pendente],
            'labels' => $labels
        ];
    }
}
