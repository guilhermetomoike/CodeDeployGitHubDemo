<?php

namespace Modules\Irpf\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Irpf\Services\IrpfQuestionService;
use Modules\Irpf\Services\ResponderPendenciaService;
use Modules\Irpf\Services\ResponderQuestionarioService;
use Modules\Irpf\Transformers\IrpfPendenciasResource;
use Modules\Irpf\Transformers\IrpfQuestionarioPendenciaResource;

class IrpfQuestionController
{
    private IrpfQuestionService $service;

    public function __construct(IrpfQuestionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }
    public function show2($ano)
    {
        $data = $this->service->getAll2($ano);
        return new JsonResponse($data);
    }

    public function store(Request $request)
    {
        $data = $this->service->create($request->all());
        return new JsonResponse([
            'message' => 'Pergunta salva com sucesso!',
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->service->update($id, $request->all());
        return new JsonResponse([
            'message' => 'Pergunta salva com sucesso!',
        ]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return new JsonResponse([
            'message' => 'Pergunta removida com sucesso!',
        ]);
    }

    public function deletePendenciaInput(int $input_id)
    {
        $this->service->deletePendenciaInput($input_id);
        return new JsonResponse([]);
    }

    public function getQuestionarioForCustomer(Request $request)
    {
        $customer_id = $request->get('customer_id', auth('api_clientes')->id());
        $queryParams = $request->query();
        $data = $this->service->getQuestionsForCustomer($customer_id, $queryParams);
        return IrpfQuestionarioPendenciaResource::collection($data);
    }

    public function getPendenciasForCustomer(Request $request)
    {
        $customer_id = $request->get('customer_id', auth('api_clientes')->id());
        $queryParams = $request->query();
        $pendencias = $this->service->getPendenciesForCustomer($customer_id, $queryParams);
        return IrpfPendenciasResource::collection($pendencias);
    }

    public function responder(Request $request, ResponderQuestionarioService $responderQuestionarioService)
    {
        $customer_id = $request->get('customer_id', auth('api_clientes')->id());
        $responderQuestionarioService->execute($customer_id, $request->post());

        return new JsonResponse(['message' => 'Respostas salvas com sucesso!']);
    }

    public function savePendencia(Request $request, ResponderPendenciaService $responderPendenciaService)
    {
        try {
            $responderPendenciaService->execute($request->post(), $request->get('customer_id'));
            return new JsonResponse(['message' => 'Pendencia salva com sucesso!']);
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
