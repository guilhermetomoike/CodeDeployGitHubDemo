<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoricoRegimeTributarioRequest;
use App\Services\HistoricoRegimeTributarioService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HistoricoRegimeTributarioController
{
    private HistoricoRegimeTributarioService $service;

    public function __construct(HistoricoRegimeTributarioService $service)
    {
        $this->service = $service;
    }

    public function getByEmpresa(int $empresa_id)
    {
        $data = $this->service->getByEmpresaId($empresa_id);
        return new JsonResponse($data);
    }

    public function store(HistoricoRegimeTributarioRequest $request)
    {
        $data = $request->validated();
        $this->service->create($data);
        return new JsonResponse([
            'message' => 'Operação realizada com sucesso!'
        ]);
    }
}
