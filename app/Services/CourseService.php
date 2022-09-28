<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class CourseService
{
    public function updateOrCreate(array $data, $id): Model
    {
        $course = Course::query()->find($id);
        return Course::query()->updateOrCreate(
            ['id' => $course ? $course->id : null],
            ['name' => $data['name']],
        );
    }

    public function index()
    {
        return Course::all();
    }
}
