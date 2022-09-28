<?php

namespace App\Services\Chart\DatasetBuilders;

use App\Services\Chart\IDataSetBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CashFlowForecastService implements IDataSetBuilderService
{
    public function buildDataset(?array $params = []): ?iterable
    {
        $invoicesByMonth = $this->getForecastsByMonth();
        return $this->qualifyDataSet($invoicesByMonth);
    }

    private function getForecastsByMonth()
    {
        return DB::select("SELECT sum(contas_receber.valor)        as total,
           month(contas_receber.vencimento) as 'month',
           year(contas_receber.vencimento)  as 'year',
           'forecast'                       as status
            from contas_receber
            where contas_receber.vencimento >= DATE_FORMAT(NOW(), '%Y-%m-01')
              and consumed_at is null
            group by month, year
            order by year, month asc
            limit 6");
    }

    private function qualifyDataSet(array $invoicesByMonth)
    {
        $dataSetForecast = ['label' => 'Previsão', 'backgroundColor' => 'rgba(24, 185, 96, 0.4)'];
        $label = [];

        foreach ($invoicesByMonth as $item) {
            $date = Carbon::create($item->year, $item->month);
            $dataSetForecast['data'][] = $item->total;
            $label[] = monthLabel($date->month);
        }

        return [
            'data' => [$dataSetForecast],
            'label' => $label
        ];
    }
}
