<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->integer('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->boolean('executed')->default(false);
            $table->string('description');
            $table->date('goal');
            $table->date('deadline');
            $table->string('tax_regime');
            $table->string('observation');

            $table->bigInteger('activity_schedule_id')->unsigned();
            $table->foreign('activity_schedule_id')->references('id')->on('activity_schedules');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
