<?php

namespace App\Http\Controllers;

use App\Services\AppSettingsService;
use Illuminate\Http\JsonResponse;

class AppSettingsController extends Controller
{
    private AppSettingsService $appSettingsService;

    public function __construct(AppSettingsService $appSettingsService)
    {
        $this->appSettingsService = $appSettingsService;
    }

    public function create($request): JsonResponse
    {
        $data = $this->appSettingsService->create($request->validated());
        return new JsonResponse($data);
    }

    public function update($request, int $id): JsonResponse
    {
        $data = $this->appSettingsService->update($id, $request->validated());
        return new JsonResponse($data);
    }
}
