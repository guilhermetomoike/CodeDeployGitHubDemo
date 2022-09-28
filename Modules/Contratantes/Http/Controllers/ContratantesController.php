<?php

namespace Modules\Contratantes\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Contratantes\Entities\Contratante;
use Modules\Contratantes\Http\Requests\ContratantesRequest;
use Modules\Contratantes\Services\ContratantesService;
use Modules\Contratantes\Transformers\ContratanteResource;

class ContratantesController extends Controller
{
    private $contratantesService;

    public function __construct(ContratantesService $contratantesService)
    {
        $this->contratantesService = $contratantesService;
    }

    public function index()
    {
        $contratantes = $this->contratantesService->getAllContratantes();

        return ContratanteResource::collection($contratantes);
    }

    public function store(ContratantesRequest $contratantesRequest)
    {
        $data = $contratantesRequest->validated();

        $contratante = $this->contratantesService->storeContratante($data);

        return new ContratanteResource($contratante);
    }

    public function show(Contratante $contratante)
    {
        return new ContratanteResource($contratante);
    }

    public function update(ContratantesRequest $contratantesRequest, Contratante $contratante)
    {
        $data = $contratantesRequest->validated();

        $contratante = $this->contratantesService->updateContratante($data, $contratante);

        return new ContratanteResource($contratante);
    }

    public function destroy(Contratante $contratante)
    {
        $this->contratantesService->deleteContratante($contratante);

        return response()->noContent();
    }
}
