<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitySchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('activity_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('status');
            $table->date('goal');
            $table->date('deadline');
            $table->string('tax_regime');
            $table->string('recurrence');
            $table->string('observation');
            $table->date('last_execution')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_schedules');
    }
}
