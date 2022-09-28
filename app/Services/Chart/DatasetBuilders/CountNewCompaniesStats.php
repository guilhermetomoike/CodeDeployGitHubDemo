<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CountNewCompaniesStats implements IDataSetBuilderService
{
    public function buildDataset($params = []): ?iterable
    {
        $defaulting = $this->getQuantities();
        return $this->qualifyDataSet($defaulting);
    }

    private function getQuantities()
    {
        $empresas = DB::select("
                    select e.id,
                   e.status_id,
                   e.created_at,
                   activity_log.created_at as data_ativacao
            from empresas e
                     left join activity_log on activity_log.subject_id = e.id
                and activity_log.subject_type = 'empresa'
                and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) = 99
                and json_unquote(json_extract(`activity_log`.`properties`, '$.\"attributes\" . \"status_id\"')) = 100
            where DATE_FORMAT(activity_log.updated_at, '%Y-%m-01') = DATE_FORMAT(now(), '%Y-%m-01')
              and activity_log.id is not null
              and e.deleted_at is null
            union
            select e.id,
                   e.status_id,
                   e.created_at,
                   activity_log.created_at as data_ativacao
            from empresas e
                     left join activity_log on activity_log.subject_id = e.id
                and activity_log.subject_type = 'empresa'
                and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) = 99
                and json_unquote(json_extract(`activity_log`.`properties`, '$.\"attributes\" . \"status_id\"')) = 100
            where e.created_at >= DATE_FORMAT(now(), '%Y-%m-01')
              and e.deleted_at is null");

        return collect($empresas)->unique('id');
    }

    private function qualifyDataSet(Collection $empresas)
    {
        $novasVendas = $empresas
            ->where('created_at', '>=', today()->firstOfMonth()->toDateString())
            ->count();
        $finalizadas = $empresas
            ->where('status_id', 100)
            ->where('data_ativacao', '>=', today()->firstOfMonth()->toDateString())
            ->count();
        return [
            'new' => $novasVendas,
            'finished' => $finalizadas
        ];
    }
}
