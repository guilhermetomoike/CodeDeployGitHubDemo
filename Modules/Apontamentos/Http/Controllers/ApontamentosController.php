<?php

namespace Modules\Apontamentos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apontamentos\Entities\Apontamento;
use Modules\Apontamentos\Http\Requests\ApontamentosRequest;
use Modules\Apontamentos\Transformers\ApontamentosResource;
use Modules\Apontamentos\Services\ApontamentosService;

class ApontamentosController extends Controller
{
    private $apontamentosService;

    public function __construct(ApontamentosService $apontamentosService)
    {
        $this->apontamentosService = $apontamentosService;
    }

    public function index()
    {
        $apontamentos = $this->apontamentosService->getAllApontamentos();
        return ApontamentosResource::collection($apontamentos);
    }

    public function store(ApontamentosRequest $request)
    {
        $data = $request->validated();
        $apontamento = $this->apontamentosService->storeApontamento($data);
        return new ApontamentosResource($apontamento);
    }

    public function update(ApontamentosRequest $request, Apontamento $apontamento)
    {
        $data = $request->validated();

        $this->apontamentosService->updateApontamento($data, $apontamento);

        return new ApontamentosResource($apontamento);
    }

    public function destroy(Apontamento $apontamento)
    {
        $this->apontamentosService->deleteApontamento($apontamento);

        return response()->noContent();
    }
}
