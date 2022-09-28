<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Models\Empresa;
use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PendingRegisterCompletionList implements IDataSetBuilderService
{
    public function buildDataset(?array $params = []): ?iterable
    {
        $dataSet = $this->getCompanies();
        return $this->qualifyDataSet($dataSet);
    }

    private function getCompanies()
    {
        return DB::select("
            select empresas.id,
                   empresas.razao_social,
                   empresas.nome_fantasia,
                   u.nome_completo as vendedor,
                   empresas.status_id,
                   empresas.created_at
            from empresas
                     left join empresa_pre_cadastros epc on empresas.id = epc.empresa_id
                     left join usuarios u on epc.usuario_id = u.id
            where empresas.status_id in (3,8,9) and empresas.deleted_at is null
            ");
    }

    private function qualifyDataSet(array $dataSet)
    {
        $dataSet = new Collection($dataSet);
        return $dataSet->transform(fn($item) => [
            'id' => $item->id,
            'razao_social' => $item->razao_social,
            'nome_fantasia' => $item->nome_fantasia,
            'status_id' => $item->status_id,
            'vendedor' => $item->vendedor,
            'created_at' => $item->created_at,
            'status_label' => Empresa::$status[$item->status_id],
        ]);
    }
}
