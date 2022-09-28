<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Facades\DB;

class CompaniesQuantityStarts implements IDataSetBuilderService
{
    public function buildDataset(?array $params): ?iterable
    {
        return $this->queryCompaniesQuantityStats();
    }

    public function queryCompaniesQuantityStats(): array
    {
        $data = DB::select("SELECT
            SUM( CASE WHEN empresas.congelada = 1 and saiu = 0 and empresas.deleted_at is null THEN 1 ELSE 0 END ) AS 'congelada',
            SUM( CASE WHEN saiu = 1 or deleted_at is not null THEN 1 ELSE 0 END ) AS 'inativa',
            SUM( CASE WHEN status_id < 100 and saiu = 0 and deleted_at is null and congelada = 0 THEN 1 ELSE 0 END ) AS 'em_abertura',
            SUM( CASE WHEN saiu = 0 And congelada = 0 and deleted_at is null and status_id = 100 THEN 1 ELSE 0 END ) AS 'ativa'
            FROM empresas");
        return $data && $data[0] ? (array)$data[0] : [];
    }
}
