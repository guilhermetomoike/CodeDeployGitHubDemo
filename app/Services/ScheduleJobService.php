<?php


namespace App\Services;


use App\Models\Schedule;

class ScheduleJobService
{
    public function getBySlug(string $slug)
    {
        return Schedule::getBySlug($slug);
    }

    public function activeBySlug(string $slug)
    {
        $schedule = $this->getBySlug($slug);
        $schedule->is_active = true;
        $schedule->save();
        return $schedule;
    }

    public function deactivateBySlug(string $slug)
    {
        $schedule = $this->getBySlug($slug);
        $schedule->is_active = false;
        $schedule->save();
        return $schedule;
    }

    public function getAll()
    {
        return Schedule::all();
    }
}
