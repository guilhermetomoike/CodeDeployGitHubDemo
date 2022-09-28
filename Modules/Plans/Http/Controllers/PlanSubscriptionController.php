<?php

namespace Modules\Plans\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Plans\Http\Requests\PlanSubscriptionRequest;
use Modules\Plans\Repositories\PlanSubscriptionRepository;
use Modules\Plans\Services\Contracts\SubscribePlanService;
use Modules\Plans\Transformers\SubscriptionResource;

class PlanSubscriptionController
{
    private PlanSubscriptionRepository $planSubscriptionRepository;
    private SubscribePlanService $subscribePlanService;

    public function __construct(
        PlanSubscriptionRepository $planSubscriptionRepository,
        SubscribePlanService $subscribePlanService
    )
    {
        $this->planSubscriptionRepository = $planSubscriptionRepository;
        $this->subscribePlanService = $subscribePlanService;
    }

    public function index()
    {
        $data = $this->planSubscriptionRepository->getSubscriptions();
        if (!$data) {
            return response()->noContent();
        }
        return SubscriptionResource::collection($data);
    }

    public function store(PlanSubscriptionRequest $request)
    {
        $data = $request->validated();
        try {
            $planSubscription = $this->subscribePlanService->execute($data);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'Erro: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse([
            'message' => 'Operação Realizada com sucesso.',
            'data' => $planSubscription
        ], Response::HTTP_CREATED);
    }

    public function destroy($payer_type, $payer_id)
    {
        $data = compact('payer_id', 'payer_type');
        $deleted = $this->planSubscriptionRepository->delete($data);
        if (!$deleted) {
            return new JsonResponse(['message' => 'Erro ao remover registro!'], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse();
    }
}
