<?php

namespace App\Http\Controllers;

use App\Jobs\MakeContratoEmpresaJob;
use App\Repositories\CartaoCreditoRepository;
use App\Services\EmpresaService;
use Illuminate\Http\Request;

class AssinaturaContratoController extends Controller
{
    /**
     * @var EmpresaService
     */
    private $empresaService;

    /**
     * @var CartaoCreditoRepository
     */
    private $cartaoCreditoRepository;

    public function __construct(EmpresaService $empresaService, CartaoCreditoRepository $cartaoCreditoRepository)
    {
        $this->empresaService = $empresaService;
        $this->cartaoCreditoRepository = $cartaoCreditoRepository;
    }

    public function index(int $empresaId)
    {
        validator(['id' => $empresaId], ['id' => 'exists:empresas'])
            ->validate();

        $empresa = $this->empresaService->getEmpresa($empresaId);

        return [
                'request_signature_key' => $empresa->contrato->extra['clicksign']['request_signature_key'],
        ];
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'empresa_id' => ['required', 'exists:empresas,id'],
            'forma_pagamento_id' => ['required'],
            'token_cartao_credito' => ['required_if:forma_pagamento_id,2'],
        ]);

        $empresa = $this->empresaService->getEmpresa($data['empresa_id']);

        $empresa->contrato->forma_pagamento_id = $data['forma_pagamento_id'];
        $empresa->contrato->save();

        if ($data['forma_pagamento_id'] == 2 && !empty($data['token_cartao_credito'])) {
            $this->cartaoCreditoRepository->storeToken([
                'token_cartao' => $data['token_cartao_credito'],
                'empresa_id' => $data['empresa_id'],
            ]);
        }

        return response()->noContent();
    }

    public function reenviar(int $empresa_id)
    {
        $empresa = $this->empresaService->getEmpresa($empresa_id);
        try {
            MakeContratoEmpresaJob::dispatchNow($empresa);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successResponse();
    }
}
