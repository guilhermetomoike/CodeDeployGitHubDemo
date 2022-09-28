<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityScheduleWalletsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_schedule_wallets', function (Blueprint $table) {
            $table->bigInteger('activity_schedules_id');
            $table->bigInteger('carteira_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_schedule_wallets');
    }
}
