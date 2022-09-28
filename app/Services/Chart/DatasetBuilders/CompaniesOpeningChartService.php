<?php


namespace App\Services\Chart\DatasetBuilders;

use App\Services\Chart\IDataSetBuilderService;
use Illuminate\Support\Facades\DB;

class CompaniesOpeningChartService implements IDataSetBuilderService
{
    private array $statusIdNeeded = [9, 3, 4, 5, 6, 7];

    public function buildDataset(?array $params): ?iterable
    {
        $label = [
            "Pré-cadastro",
            // "Aguardando assinatura",
            "Aguardando certificado",
            "Aguardando CNPJ",
            "Aguardando alvará",
            "Aguardando acesso",
            "Aguardando simples"
        ];
        $data = [];

        $status = $this->getTotalEmpresaFromStatus($params['carteira_id']);

        foreach ($this->statusIdNeeded as $value) {
            $data[] = $status->keyBy('status_id')->get($value)->total ?? 0;
        }

        return [
            "label" => $label,
            "datasets" => [
                [
                    "backgroundColor" => 'rgba(75, 192, 192, 0.5)',
                    "data" => $data
                ]
            ]
        ];
    }

    public function getTotalEmpresaFromStatus($params)
    {
        $bind = implode(',', array_fill(0, count($this->statusIdNeeded), '?'));
        if( $params == 0  ){
        $data = DB::select("
            select e.status_id, COUNT(e.status_id) as total from empresas e
        where e.status_id in ($bind)
            and e.deleted_at is null
            group by (e.status_id)", $this->statusIdNeeded);
        }else{
            $data = DB::select("
            select e.status_id, COUNT(e.status_id) as total from empresas e
            left join carteira_empresa  on e.id = carteira_empresa.empresa_id
            where carteira_empresa.carteira_id = $params
            and e.status_id in ($bind)
            and e.deleted_at is null
            group by (e.status_id)", $this->statusIdNeeded);
        }

        return Collect($data);
    }
}
