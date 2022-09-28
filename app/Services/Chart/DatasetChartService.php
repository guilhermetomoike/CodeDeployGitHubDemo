<?php


namespace App\Services\Chart;


class DatasetChartService
{
    public function getQualifiedDataset(IDataSetBuilderService $dataSetBuilderService, ?array $params = []): ?iterable
    {
        return $dataSetBuilderService->buildDataset($params);
    }
}
