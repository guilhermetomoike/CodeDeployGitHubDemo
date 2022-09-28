<?php

namespace Modules\Evaluation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Evaluation\Http\Requests\EvaluationEntityRequest;
use Modules\Evaluation\Services\EvaluationEntityService;

class EvaluationEntityController extends Controller
{
    private EvaluationEntityService $evaluationEntityService;

    public function __construct(EvaluationEntityService $evaluationEntityService)
    {
        $this->evaluationEntityService = $evaluationEntityService;
    }

    public function index(int $evaluation_id, string $evaluable_type, int $evaluable_id)
    {
        $evaluation = $this->evaluationEntityService->getEvaluationsByEntity($evaluation_id, $evaluable_type, $evaluable_id);
        return new JsonResponse($evaluation);
    }

    public function store(EvaluationEntityRequest $request)
    {
        $data = $request->validated();
        try {
            $evaluation = $this->evaluationEntityService->register($data);
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 400);
        }
        return new JsonResponse($evaluation);
    }
}
