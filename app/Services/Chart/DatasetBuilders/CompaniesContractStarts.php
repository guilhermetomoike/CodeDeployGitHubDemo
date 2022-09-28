<?php

namespace App\Services\Chart\DatasetBuilders;

use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Facades\DB;

class CompaniesContractStarts implements IDataSetBuilderService
{
    public function buildDataset(?array $params): ?iterable
    {
        return $this->queryCompaniesContractStats();
    }

    public function queryCompaniesContractStats(): array
    {
        $data = DB::select("SELECT
            SUM( CASE WHEN empresas.status_id = 2 THEN 1 ELSE 0 END ) AS 'aguardando_assinatura',
            SUM( CASE WHEN empresas.status_id != 2 AND contratos.extra IS NULL THEN 1 ELSE 0 END ) AS 'nao_enviado',
            SUM( CASE WHEN empresas.status_id > 2 AND contratos.extra IS NOT NULL THEN 1 ELSE 0 END ) AS 'assinado'
            FROM empresas
             JOIN contratos on contratos.empresas_id = empresas.id
            WHERE saiu = 0 AND empresas.deleted_at IS NULL");
        return $data && $data[0] ? (array)$data[0] : [];
    }
}
