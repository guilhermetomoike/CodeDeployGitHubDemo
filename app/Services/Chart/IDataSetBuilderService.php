<?php


namespace App\Services\Chart;


interface IDataSetBuilderService
{
    public function buildDataset(?array $params): ?iterable;
}
