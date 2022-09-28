<?php

namespace App\Http\Controllers\OrdemServico;

use App\Http\Controllers\Controller;
use App\Http\Requests\OsBaseValidator;
use App\Models\OrdemServico\OrdemServicoBase;
use App\Services\OrdemServico\OrdemServicoService;

class OrdemServicoBaseController extends Controller
{

    public function index(OrdemServicoService $ordemServicoService)
    {
        return response($ordemServicoService->getOsBase());
    }

    public function store(OsBaseValidator $request, OrdemServicoService $ordemServicoService)
    {
        $storedOsBase = $ordemServicoService->cadastrarOrdemServicoBase($request->all());

        return $this->created($storedOsBase);
    }

    public function destroy(int $id)
    {
        $ordem_servico_base = OrdemServicoBase::find($id);

        $deleted_os_base = $ordem_servico_base->delete();

        if (!$deleted_os_base) {
            return $this->errorResponse();
        }

        return $this->successResponse();
    }

}
