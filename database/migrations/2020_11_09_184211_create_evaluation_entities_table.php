<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('answer')->nullable();
            $table->text('observation')->nullable();
            $table->morphs('evaluable');
            $table->foreignId('evaluation_id');
            $table->foreignId('customer_id');
            $table->foreignId('user_id');
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
        Schema::dropIfExists('evaluation_entities');
    }
}
