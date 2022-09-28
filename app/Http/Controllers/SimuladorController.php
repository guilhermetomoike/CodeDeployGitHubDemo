<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientePgblResource;
use App\Http\Resources\SimulacaoPgblByEmpresaResource;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\PreQueue;
use App\Models\Prolabore;
use App\Services\ReceitaService;
use App\Services\Simulador\SimulatorService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Artisan;

class SimuladorController extends Controller
{
    private SimulatorService $service;

    public function __construct(SimulatorService $service)
    {
        $this->service = $service;
    }

    public function showPgbl(ReceitaService $receitaService, $customer_id)
    {
        $incomes = $receitaService->getYearlyByCustomer($customer_id);
        $pgblSimulation = $this->service->Pgbl->simulate($incomes->flatten());
        return new SimulacaoPgblByEmpresaResource($pgblSimulation);
    }

}
