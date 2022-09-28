<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Services\Chart\IDataSetBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CashFlowStatsService implements IDataSetBuilderService
{
    public function buildDataset(?array $params = []): ?iterable
    {
        $invoicesByMonth = $this->getInvoicesByMonth();
        return $this->qualifyDataSet(array_reverse($invoicesByMonth));
    }

    private function getInvoicesByMonth()
    {
        return DB::select("SELECT sum(fatura.subtotal)           as total,
       month(fatura.data_competencia) as 'month',
       year(fatura.data_competencia)  as 'year',
       'expected'                     as status
        from fatura
        where
              fatura.data_competencia >= '2020-03-01'
          and fatura.data_competencia <= DATE_SUB(NOW(), INTERVAL 2 MONTH)
          and status in ('pendente', 'processando', 'atrasado', 'pago')
        group by month(fatura.data_competencia), YEAR(fatura.data_competencia)
            union
        SELECT sum(fatura.subtotal)           as total,
       month(DATE_SUB(fatura.data_recebimento, INTERVAL 1 MONTH)) as 'month',
       year(DATE_SUB(fatura.data_recebimento, INTERVAL 1 MONTH))  as 'year',
       'payed'                        as status
        from fatura
        where
              fatura.data_competencia >= '2020-03-01'
              and fatura.data_competencia <= DATE_SUB(NOW(), INTERVAL 2 MONTH)
          and status = 'pago'
        group by month, year
        order by year, month desc
        limit 24");
    }

    private function qualifyDataSet(array $invoicesByMonth)
    {
        $dataSetExpected = ['label' => 'Previsto', 'backgroundColor' => 'rgba(66, 153, 225, 0.5)'];
        $dataSetPaid = ['label' => 'Recebido', 'backgroundColor' => 'rgba(90, 212, 131, 0.5)'];
        $label = [];

        foreach ($invoicesByMonth as $item) {
            $date = Carbon::create($item->year, $item->month);
            if ($date->greaterThan(today()->subMonths(2))) continue;

            if ($item->status === 'expected') {
                $dataSetExpected['data'][] = $item->total;
                continue;
            }

            $dataSetPaid['data'][] = $item->total;
            $label[] = monthLabel($date->addMonth()->month);
        }

        return [
            'data' => [$dataSetExpected, $dataSetPaid],
            'label' => $label
        ];
    }
}
