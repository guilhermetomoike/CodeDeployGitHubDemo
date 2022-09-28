<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    private CourseService $coursesService;

    public function __construct(CourseService $coursesService)
    {
        $this->coursesService = $coursesService;
    }

    public function index()
    {
        return $this->coursesService->index();
    }

    public function store(CourseRequest $request, int $id = null): JsonResponse
    {
        $data = $this->coursesService->updateOrCreate($request->validated(), $id);
        return new JsonResponse($data);
    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
