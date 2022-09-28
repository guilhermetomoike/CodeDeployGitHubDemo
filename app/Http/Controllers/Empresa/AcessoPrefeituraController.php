<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcessoPrefeituraRequest;
use App\Http\Resources\AcessoPrefeituraResource;
use App\Services\Empresa\AcessoPrefeituraService;

class AcessoPrefeituraController extends Controller
{

    private AcessoPrefeituraService $acessoPrefeituraService;

    public function __construct(AcessoPrefeituraService $acessoPrefeituraService)
    {
        $this->acessoPrefeituraService = $acessoPrefeituraService;
    }

    public function index(int $empresa_id)
    {
        $acessosPrefeitura = $this->acessoPrefeituraService->getAcessosPrefeituraByEmpresaId($empresa_id);
        return AcessoPrefeituraResource::collection($acessosPrefeitura);
    }

    public function store(AcessoPrefeituraRequest $request, int $empresa_id)
    {
        $data = $request->validated();
        $acessoPrefeitura = $this->acessoPrefeituraService->storeAcessoPrefeitura($data, $empresa_id);
        return new AcessoPrefeituraResource($acessoPrefeitura);
    }

    public function update(AcessoPrefeituraRequest $request, int $empresa_id, int $id)
    {
        $data = $request->validated();
        $acessoPrefeitura = $this->acessoPrefeituraService->updateAcessoPrefeitura($data, $id);
        return new AcessoPrefeituraResource($acessoPrefeitura);
    }
}
