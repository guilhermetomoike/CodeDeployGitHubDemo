<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Models\Cliente;
use App\Models\Empresa;
use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CountAlvarasStats implements IDataSetBuilderService
{
    public function buildDataset($params = []): ?iterable
    {
        $defaulting = $this->getQuantities($params);
        return $this->qualifyDataSet($defaulting);
    }

    private function getQuantities($params)
    {

        if ($params['carteira_id'] != 0 ) {
            $alvaras = DB::select("
        SELECT ea.empresa_id,
                   ea.updated_at as data_alvara
            from empresas_alvaras ea
                  left join carteira_empresa  on ea.empresa_id = carteira_empresa.empresa_id
                     left join empresa_pre_cadastros epc on ea.empresa_id = epc.empresa_id
                     left join activity_log on activity_log.subject_id = ea.empresa_id and activity_log.subject_type = 'empresa' and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) >= 5
            where DATE_FORMAT(ea.updated_at, '%Y-%m-01') = DATE_FORMAT(now(), '%Y-%m-01')
              and DATE_FORMAT(activity_log.updated_at, '%Y-%m-01') = DATE_FORMAT(ea.updated_at, '%Y-%m-01')
              and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) >= 5 
              and carteira_empresa.carteira_id = " . $params['carteira_id'] . "
            group by ea.empresa_id, data_alvara");
        } else {
            $alvaras = DB::select("
            SELECT ea.empresa_id,
                       ea.updated_at as data_alvara
                from empresas_alvaras ea
                 
                         left join empresa_pre_cadastros epc on ea.empresa_id = epc.empresa_id
                         left join activity_log on activity_log.subject_id = ea.empresa_id and activity_log.subject_type = 'empresa' and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) >= 5
                where DATE_FORMAT(ea.updated_at, '%Y-%m-01') = DATE_FORMAT(now(), '%Y-%m-01')
                  and DATE_FORMAT(activity_log.updated_at, '%Y-%m-01') = DATE_FORMAT(ea.updated_at, '%Y-%m-01')
                  and json_unquote(json_extract(`activity_log`.`properties`, '$.\"old\" . \"status_id\"')) >= 5 
                
                group by ea.empresa_id, data_alvara");
        }

        return new Collection($alvaras);
    }

    private function qualifyDataSet(Collection $alvaras)
    {
        $thisWeek = $alvaras->where('data_alvara', '>=', today()->floorWeek()->toDateTimeString())->count();
        $thisMonth = $alvaras->count();
        return [
            'in_week' => $thisWeek,
            'in_month' => $thisMonth
        ];
    }
}
