<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaSociosUpdateRequest;
use App\Models\Empresa;
use App\Services\Empresa\UpdateSociosEmpresaService;

class EmpresaSociosUpdateController extends Controller
{
    private $updateSociosEmpresaService;

    public function __construct(UpdateSociosEmpresaService $updateSociosEmpresaService) {
        $this->updateSociosEmpresaService = $updateSociosEmpresaService;
    }

    public function update(EmpresaSociosUpdateRequest $request, int $empresa_id) {
        $empresa = Empresa::find($empresa_id);

        $this->updateSociosEmpresaService->execute($empresa, $request['socios']);

        return $empresa->socios;
    }
}
