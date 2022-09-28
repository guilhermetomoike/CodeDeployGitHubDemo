<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Models\Empresa;
use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TimeByStepInOpeningService implements IDataSetBuilderService
{
    public function buildDataset(?array $params = []): ?iterable
    {
        $dataSet = $this->getQuery($params['carteira_id']);
        return $this->qualifyDataSet($dataSet, $params['measure']);
    }

    private function getQuery($params)
    {
        if ($params == 0) {
            return DB::select("
               select activity_log.id,
               activity_log.subject_id,
               activity_log.created_at,
               json_unquote(json_extract(`properties`, '$.\"old\" . \"status_id\"'))   old_status,
               json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) new_status
            from `activity_log`
          
            where `subject_type` = 'empresa'
              and created_at > DATE_SUB(NOW(), INTERVAL 2 MONTH)
              and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
              and json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
              and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) <>
                  json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"'))
               
            ");
        } else {
            return DB::select("
            select activity_log.id,
            activity_log.subject_id,
            activity_log.created_at,
            json_unquote(json_extract(`properties`, '$.\"old\" . \"status_id\"'))   old_status,
            json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) new_status
         from `activity_log`
         left join carteira_empresa  on  carteira_empresa.empresa_id  = activity_log.subject_id 
         where `subject_type` = 'empresa'
           and created_at > DATE_SUB(NOW(), INTERVAL 2 MONTH)
           and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
           and json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"')) not in (1, 70, 71, 80, 81, 100)
           and json_unquote(json_extract(`properties`, '$.\"old\".\"status_id\"')) <>
               json_unquote(json_extract(`properties`, '$.\"attributes\".\"status_id\"'))
               and carteira_empresa.carteira_id = " . $params . "
         ");
        }
    }

    private function qualifyDataSet(array $dataSet, ?string $measure)
    {
        $dividBy = $measure === 'hours' || !$measure ? 1 : 24;
        $dataSet = new Collection($dataSet);
        $statusIdNeeded = [3, 4, 5, 6, 7];

        $label = [
            "Certificado",
            "CNPJ",
            "Alvará",
            "NFSE",
            "Simples",
        ];
        $data = [];

        $groupedDataBySubject = $dataSet
            ->groupBy('subject_id')
            ->map(function (Collection $itemsByCompany) use ($statusIdNeeded) {
                $times = [];
                foreach ($statusIdNeeded as $status_id) {
                    $startedAt = $itemsByCompany
                        ->filter(fn ($item) => $item->new_status == $status_id)
                        ->first()->created_at ?? false;

                    $finishedAt = $itemsByCompany
                        ->filter(fn ($item) => $item->old_status == $status_id)
                        ->first()->created_at ?? false;

                    if ($startedAt && $finishedAt) {
                        $times[$status_id] = (strtotime($finishedAt) - strtotime($startedAt)) / 60;
                    }
                }

                return $times;
            });

        foreach ($statusIdNeeded as $statusNeeded) {
            $averageMinutesForTheStep = $groupedDataBySubject->avg($statusNeeded);
            $data[] = round(($averageMinutesForTheStep / 60) / $dividBy);
        }

        return [
            "label" => $label,
            "datasets" => [
                [
                    "backgroundColor" => 'rgba(255, 159, 64, 0.5)',
                    "data" => $data
                ]
            ]
        ];
    }
}
