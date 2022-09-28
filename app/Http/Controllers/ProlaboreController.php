<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmpresaLiberacaoProlaboreResource;
use App\Models\Empresa;
use App\Models\Prolabore;
use App\Services\ProlaboreService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ProlaboreController extends Controller
{
    /**
     * @var ProlaboreService
     */
    private $prolaboreService;

    /**
     * ProlaboreController constructor.
     * @param ProlaboreService $prolaboreService
     */
    public function __construct(ProlaboreService $prolaboreService)
    {
        $this->prolaboreService = $prolaboreService;
    }

    public function index($id)
    {
        $prolabores = Prolabore::getBySociosId(Empresa::getSociosId($id));

        if (!$prolabores) {
            return $this->badRequest('Falhao ao carregar prolabores!');
        }

        $prolabores = $prolabores->groupBy('clientes_id');

        $dateTime = Carbon::now()->firstOfMonth();

        $dataFim = $dateTime->setMonth(11)->format('Y-m-d');

        $dataInicio = $dateTime->subYears(1)->setMonth(12)->format('Y-m-d');

        $period = CarbonPeriod::create($dataInicio, '1 month', $dataFim);

        $rendimento = [];

        foreach ($prolabores as $key => $value) {
            foreach ($period as $dt) {
                $data = $dt->format("Y-m-d");
                $rendimento[$key][$data] = $value->where('data_competencia', '=', $data);
            }
        }

        return response()->json([
            'data' => $rendimento
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * retorna lista de empresas para liberacao de prolabore
     * @param $request ->empresa_id
     * @param $request ->liberadas
     * @param $request ->competencia
     * @param $request ->page
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Validation\ValidationException
     */
    public function listaLiberacao(Request $request)
    {
        $this->validate($request, ['data_competencia' => 'required|date_format:Y-m-01']);

        $empresas = $this->prolaboreService->getListaLiberacao($request);

        if (!$empresas) {
            return $this->errorResponse();
        }

        return EmpresaLiberacaoProlaboreResource::collection($empresas);
    }

    /**
     * recebe id dos socios e respctivamente o valor dos prolabores
     * para realizar liberacao com data de competencia
     * @param Request $request
     * @param int $empresa_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function liberarEmpresa(Request $request, int $empresa_id)
    {
        $this->validate($request, [
            'data_competencia' => 'required|date_format:Y-m-01',
            'prolabores' => 'required|array'
        ]);

        $created_prolabore = $this->prolaboreService->liberarProlaboreEmpresa($empresa_id, $request->all());

        if (!$created_prolabore) {
            return $this->errorResponse();
        }

        return $this->successResponse();
    }

    /**
     * recebe uma data competencia e um id de empresa para realizar estorno
     * @param Request $request
     * @param int $empresa_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function estornarLiberacao(Request $request)
    {
        $this->validate($request, [
            'data_competencia' => 'required|date_format:Y-m-01',
            'empresa_id' => 'required',
        ]);

        $estornado = $this->prolaboreService->estornarLiberacao(
            $request->empresa_id, $request->data_competencia
        );

        if (!$estornado) {
            return $this->errorResponse();
        }

        return $this->successResponse();
    }

}
