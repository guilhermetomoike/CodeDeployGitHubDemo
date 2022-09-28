<?php

namespace Modules\Activity\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Activity\Entities\ActivitySchedule;
use Modules\Activity\Entities\ActivityScheduleWallet;

class ActivityScheduleService
{
    public function create(array $data):? ActivitySchedule
    {
        $activitySchedule = null;

        DB::transaction(function () use (&$activitySchedule, $data) {
            $activitySchedule = new ActivitySchedule($data);
            $activitySchedule = $this->setValues($activitySchedule, $data);

            $activitySchedule->save();
            $this->saveWallters($activitySchedule, $data['wallter_id']);
        });

        return $activitySchedule;
    }

    public function update(ActivitySchedule $activitySchedule, array $data):? ActivitySchedule
    {
        DB::transaction(function () use (&$activitySchedule, $data) {
            $activitySchedule = $this->setValues($activitySchedule, $data);

            $activitySchedule->save();
            $this->saveWallters($activitySchedule, $data['wallter_id']);
        });

        return $activitySchedule;
    }

    public function delete(ActivitySchedule $activitySchedule): void
    {
        DB::transaction(function () use (&$activitySchedule) {
            $activitySchedule->delete();
        });
    }

    private function setValues(ActivitySchedule $activitySchedule, array $data): ActivitySchedule
    {
        $gols = new Carbon($data['goal']);
        $deadline = new Carbon($data['deadline']);

        $activitySchedule->description = $data['description'];
        $activitySchedule->goal = $gols->toDateString();
        $activitySchedule->deadline = $deadline->toDateString();
        $activitySchedule->observation = $data['observation'];
        $activitySchedule->recurrence = $data['recurrence'];
        $activitySchedule->status = $data['status'];

        return $activitySchedule;
    }

    private function saveWallters(ActivitySchedule $activitySchedule, array $wallters): void
    {
        foreach ($wallters as $wallter) {
            $newWalter = new ActivityScheduleWallet();
            $newWalter->activity_schedules_id = $activitySchedule->id;
            $newWalter->carteira_id = $wallter['id'];

            $newWalter->save();
        }
    }
}
