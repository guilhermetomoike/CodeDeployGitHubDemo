<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteCourseRequest;
use App\Http\Requests\ConfirmCoursesRequest;
use App\Services\AppSettingsService;
use App\Services\ClienteCourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClienteCourseController extends Controller
{
    private ClienteCourseService $clienteCourseService;
    private AppSettingsService $appSettingsService;

    public function __construct(ClienteCourseService $clienteCourseService, AppSettingsService $appSettingsService)
    {
        $this->clienteCourseService = $clienteCourseService;
        $this->appSettingsService = $appSettingsService;
    }

    public function index()
    {
        return $this->clienteCourseService->index();
    }

    public function store(ClienteCourseRequest $request, int $id = null): JsonResponse
    {
        $data = $this->clienteCourseService->updateOrCreate($request->validated(), $id);
        return new JsonResponse($data);
    }

    public function show(int $cliente_id): JsonResponse
    {
        $course = $this->clienteCourseService->getCoursesByClienteId($cliente_id);
        return new JsonResponse($course ?? []);
    }

    public function confirm(ConfirmCoursesRequest $request, int $cliente_id)
    {
        $data = $request->validated();
        $result = $this->clienteCourseService->confirm($data);
        if (!$result) {
            return new JsonResponse(['message' => 'Não foi possível realizar a operação!'], 400);
        }
        $this->appSettingsService->createOrUpdatedAccess('cliente', $cliente_id,'course', 'cliente-course');
        return new JsonResponse(['message' => 'Operação realizada com sucesso!']);
    }

    public function inactivateCourse(int $id)
    {
        try {
            $this->clienteCourseService->inactivate($id);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Não foi possível realizar a operação. ' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['message' => 'Operação Realizada com sucesso']);
    }
}
