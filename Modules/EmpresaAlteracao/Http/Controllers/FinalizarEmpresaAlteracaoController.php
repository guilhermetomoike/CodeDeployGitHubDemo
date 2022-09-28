<?php

namespace Modules\EmpresaAlteracao\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;
use Modules\EmpresaAlteracao\Http\Resources\EmpresaAlteracao as EmpresaAlteracaoResource;
use Modules\EmpresaAlteracao\Services\FinalizarEmpresaAlteracaoService;

class FinalizarEmpresaAlteracaoController extends Controller
{
    public function __invoke(EmpresaAlteracao $empresaAlteracao)
    {
        $finalizarEmpresaAlteracaoService = new FinalizarEmpresaAlteracaoService($empresaAlteracao);

        $finalizarEmpresaAlteracaoService->finalizar();

        return new EmpresaAlteracaoResource($empresaAlteracao);
    }
}
