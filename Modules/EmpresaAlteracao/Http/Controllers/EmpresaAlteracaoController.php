<?php

namespace Modules\EmpresaAlteracao\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Modules\EmpresaAlteracao\Entities\EmpresaAlteracao;
use Modules\EmpresaAlteracao\Http\Requests\EmpresaAlteracaoStoreRequest;
use Modules\EmpresaAlteracao\Http\Requests\EmpresaAlteracaoUpdateRequest;
use Modules\EmpresaAlteracao\Http\Resources\EmpresaAlteracao as EmpresaAlteracaoResource;
use Modules\EmpresaAlteracao\Http\Resources\EmpresaAlteracaoCollection;
use Modules\EmpresaAlteracao\Services\EmpresaAlteracaoService;

class EmpresaAlteracaoController extends Controller
{
    private EmpresaAlteracaoService $empresaAlteracaoService;

    public function __construct(EmpresaAlteracaoService $empresaAlteracaoService)
    {
        $this->empresaAlteracaoService = $empresaAlteracaoService;
    }

    public function index(Request $request)
    {
        $empresaAlteracoes = EmpresaAlteracao::naoFinalizado()->get();

        return new EmpresaAlteracaoCollection($empresaAlteracoes);
    }

    public function store(EmpresaAlteracaoStoreRequest $request)
    {
        $empresaAlteracao = $this->empresaAlteracaoService->create($request);

        return new EmpresaAlteracaoResource($empresaAlteracao);
    }

    public function show(Request $request, EmpresaAlteracao $empresaAlteracao)
    {
        return new EmpresaAlteracaoResource($empresaAlteracao);
    }

    public function update(EmpresaAlteracaoUpdateRequest $request, EmpresaAlteracao $empresaAlteracao)
    {
        if ($empresaAlteracao->status_id >= EmpresaAlteracao::STATUS_ALTERACAO) {
            $empresaAlteracao->update($request->validated());
        }

        if ($empresaAlteracao->status_id == EmpresaAlteracao::STATUS_PAGAMENTO) {
            $empresaAlteracao->updateStatus(EmpresaAlteracao::STATUS_ALTERACAO);
        }

        return new EmpresaAlteracaoResource($empresaAlteracao);
    }

    public function destroy(Request $request, EmpresaAlteracao $empresaAlteracao)
    {
        $empresaAlteracao->delete();

        return response()->noContent();
    }
}
