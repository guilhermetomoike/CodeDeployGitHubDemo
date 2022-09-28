<?php

namespace App\Services;

use App\Models\ClienteCourse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ClienteCourseService
{
    public function updateOrCreate(array $data, $id): Model
    {
        $clienteCourse = ClienteCourse::query()->find($id);
        return ClienteCourse::query()->updateOrCreate(
            ['id' => $clienteCourse ? $clienteCourse->id : null],
            [
                'cliente_id' => $data['cliente_id'],
                'course_id' => $data['course_id'],
                'ies_id' => $data['ies_id'],
                'initial_date' => $data['initial_date'],
                'conclusion_date' => $data['conclusion_date'],
                'status' => 'active',
            ],
        );
    }

    public function index()
    {
        return ClienteCourse::all();
    }

    public function getCoursesByClienteId(int $cliente_id): Collection
    {
        return ClienteCourse::query()
            ->where('cliente_id', $cliente_id)
            ->with(['course', 'ies'])->get();
    }

    public function confirm(array $data)
    {
        try {
            foreach ($data as $course) {
                $this->updateOrCreate($course, $course['id']);
            }
            return true;
        } catch (\Exception $e) {
            Log::error('Course confirmation error: ' . $e->getMessage());
            return false;
        }
    }

    public function inactivate(int $id)
    {
        return ClienteCourse::query()->where('id', $id)->update(array('status' => 'inactive'));
    }
}
