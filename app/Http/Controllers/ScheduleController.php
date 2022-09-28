<?php

namespace App\Http\Controllers;

use App\Services\ScheduleJobService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScheduleController extends Controller
{
    private ScheduleJobService $scheduleJobService;

    public function __construct(ScheduleJobService $scheduleJobService)
    {
        $this->scheduleJobService = $scheduleJobService;
    }

    public function index()
    {
        $schedule = $this->scheduleJobService->getAll();
        return new JsonResponse($schedule);
    }

    public function getBySlug(string $slug)
    {
        $schedule = $this->scheduleJobService->getBySlug($slug);
        return new JsonResponse($schedule);
    }

    public function activeBySlug(string $slug)
    {
        $schedule = $this->scheduleJobService->activeBySlug($slug);
        return new JsonResponse($schedule);
    }

    public function deactivateBySlug(string $slug)
    {
        $schedule = $this->scheduleJobService->deactivateBySlug($slug);
        return new JsonResponse($schedule);
    }
}
