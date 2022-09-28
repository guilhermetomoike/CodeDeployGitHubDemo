<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('endereco');
            $table->string('telefone')->nullable();
            $table->string('instituicao');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('place_id');
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
        Schema::dropIfExists('hospitais');
    }
}
