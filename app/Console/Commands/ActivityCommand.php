<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\Entities\ActivitySchedule;

class ActivityCommand extends Command
{
    protected $signature = 'activity:run';

    protected $description = 'Check all activity schedules and make activities';

    public function handle()
    {
        $activitiesSchedules = ActivitySchedule::all();

        foreach ($activitiesSchedules as $activitySchedule) {
            if (!$activitySchedule->executableCheck()) {
                continue;
            }

            $activitySchedule->execute();
        }

        return 0;
    }
}
