<?php

namespace Modules\Plans\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Plans\Http\Requests\PlanRequest;
use Modules\Plans\Repositories\PlansRepository;
use Modules\Plans\Services\Contracts\CreatePlanService;
use Modules\Plans\Services\Contracts\UpdatePlanService;
use Modules\Plans\Transformers\PlanResource;

class PlansController extends Controller
{

    public function index(PlansRepository $plansRepository)
    {
        $plans = $plansRepository->all();
        if (!$plans) {
            return response()->noContent();
        }
        return PlanResource::collection($plans);
    }

    public function store(PlanRequest $request, CreatePlanService $createPlanService)
    {
        $data = $request->validated();
        $plan = $createPlanService->execute($data);
        return response()->json($plan, Response::HTTP_CREATED);
    }

    public function show($id, PlansRepository $repository)
    {
        $plan = $repository->geyById($id);
        return response()->json($plan);
    }

    public function update(PlanRequest $request, $id, UpdatePlanService $updatePlanService)
    {
        $data = $request->validated();
        $plan = $updatePlanService->execute($id, $data);
        return response()->json([
            'data' => $plan,
            'message' => 'Operação Realizada com sucesso',
        ]);
    }

    public function destroy($id, PlansRepository $repository)
    {
        try {
            $repository->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Não foi possível realizar a operação. ' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json(['message' => 'Operação Realizada com sucesso']);
    }
}
