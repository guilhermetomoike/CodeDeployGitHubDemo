<?php

namespace Modules\Evaluation\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Evaluation\Http\Requests\EvaluationRequest;
use Modules\Evaluation\Services\EvaluationService;
use Symfony\Component\HttpFoundation\Request;

class EvaluationController extends Controller
{
    private EvaluationService $evaluationService;

    public function __construct(EvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }

    public function index(Request $request, string $slug)
    {
        $evaluation = $this->evaluationService->getEvaluation($slug, $request->get('companyId'));
        return new JsonResponse($evaluation);
    }

    public function store(EvaluationRequest $request)
    {
        return $this->evaluationService->register($request->validated());
    }

    public function update(EvaluationRequest $request, int $id)
    {
        return $this->evaluationService->update($id, $request->validated());
    }
}
