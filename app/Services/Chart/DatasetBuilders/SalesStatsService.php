<?php


namespace App\Services\Chart\DatasetBuilders;


use App\Services\Chart\IDataSetBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesStatsService implements IDataSetBuilderService
{
    public function buildDataset(?array $params): ?iterable
    {
        $users = $this->getUsersSellers();
        $sales = collect($this->getQuantityBySellerByMonth());
        return $this->qualifyDataSet($users, $sales);
    }

    public function getUsersSellers()
    {
        $data = DB::select("select
        usuario_id,
        u.nome_completo
        from empresa_pre_cadastros epc
        join usuarios u on epc.usuario_id = u.id
        where u.id in ( 1,87)
        group by usuario_id");

        return $data;
    }

    public function getQuantityBySellerByMonth()
    {
        $data = DB::select("SELECT u.id,
            u.nome_completo,
            COUNT(u.id) as total,
            month(c.signed_at) as 'month',
            year(c.signed_at)  as 'year'
        from empresa_pre_cadastros epc
        join usuarios u on epc.usuario_id = u.id
        join contratos c on epc.empresa_id = c.empresas_id
        join empresas e on epc.empresa_id = e.id
        where c.signed_at IS NOT NULL
        and e.deleted_at is null
        group by month(c.signed_at), YEAR(c.signed_at), epc.usuario_id");

        return $data;
    }

    public function qualifyDataSet($users, $preCadastro)
    {
        $data = [];

        $label = $this->setLabel(Carbon::now()->subMonths(6));

        foreach ($users as $key => $u) {
            array_push($data, [
                'label' => strtok($u->nome_completo, ' '),
                'backgroundColor' => $this->setColor($key),
                'data' => $this->setData($preCadastro, $u, Carbon::now()->subMonth(6))
            ]);
        }

        // meta de vendas
        array_push($data, [
            'label' => 'Meta',
            'data' => [15, 20, 15, 28, 11, 22, 15],
            'type' => 'line',
            'backgroundColor' => 'transparent'
        ]);

        return ['data' => $data, 'label' => $label];
    }

    public function setLabel($date)
    {
        $label = [];
        $i = 0;
        while ($i <= 6) {
            array_push($label, monthLabel($date->month));

            $date->addMonth(1);
            $i++;
        }

        return $label;
    }

    public function setColor($key)
    {
        $colors = [
            'rgba(75, 192, 192, 0.5)',
            'rgba(255, 159, 64, 0.5)',
            'rgba(176, 25, 132, 0.5)',
            'rgba(54, 162, 235, 0.5)',
            'rgba(255, 206, 86, 0.5)',
            'rgba(75, 192, 192, 0.5)',
            'rgba(255, 99, 132, 0.5)',
            'rgba(153, 102, 255, 0.5)',
            'rgba(145, 140, 64, 0.5)',
            'rgba(04, 138, 64, 0.5)',
            'rgba(34, 50, 64, 0.5)',
            'rgba(200, 139, 64, 0.5)',
            'rgba(225, 254, 64, 0.5)',
            'rgba(10, 165, 64, 0.5)',
            'rgba(186, 145, 64, 0.5)',
            'rgba(230, 786, 64, 0.5)',
            'rgba(245, 196, 64, 0.5)',
            'rgba(132, 137, 64, 0.5)',
            'rgba(123, 239, 64, 0.5)',
        ];

        if (empty($colors[$key])) {
            return 'rgba(255, 99, 132, 0.5)';
        }

        return $colors[$key];
    }

    public function setData($preCadastro, $user, $initial)
    {
        $data = [];
        $i = 0;
        while ($i <= 6) {
            if (!empty($preCadastro->where('id', $user->usuario_id)->where('month', $initial->month)->where('year', $initial->year)->first())) {
                array_push($data, $preCadastro->where('id', $user->usuario_id)->where('month', $initial->month)->where('year', $initial->year)->sum('total'));
            } else {
                array_push($data, 0);
            }

            $initial->addMonth(1);
            $i++;
        }

        return $data;
    }
}
