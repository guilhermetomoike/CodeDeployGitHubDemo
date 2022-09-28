<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Prolabore extends Model
{
    protected $table = 'empresas_prolabores';

    protected $fillable = [
        'clientes_id', 'empresas_id', 'cnpj', 'prolabore', 'inss', 'irrf', 'comprovante', 'data_competencia'
    ];

    /**
     * Recebe um array de ids de clientes e retorna uma colecao de prolabores dos ultimos 12 meses
     * podendo conter mais de 1 prolabore por mes por cliente
     * @param array $ids
     * @return Collection
     */
    public static function getBySociosId(array $ids): Collection
    {
        $dateTime = Carbon::now()->firstOfMonth();

        $dataFim = $dateTime->setMonth(11)->format('Y-m-d');

        $dataInicio = $dateTime->subYears(1)->setMonth(12)->format('Y-m-d');

        return self::query()
            ->whereBetween('data_competencia', [$dataInicio, $dataFim])
            ->whereIn('clientes_id', $ids)
            ->get();
    }

}
