<?php


namespace App\Http\Controllers\Empresa;


use App\Http\Requests\Empresa\CongelarEmpresaRequest;
use App\Services\Empresa\CongelarEmpresaService;

class CongelarEmpresaController
{
    public function __invoke(CongelarEmpresaRequest $request, CongelarEmpresaService $congelarEmpresaService)
    {
        $data = $request->validated();
        $congelarEmpresaService->execute($data);
        return response()->json(['message' => 'Congelamento registrado!']);
    }
}
