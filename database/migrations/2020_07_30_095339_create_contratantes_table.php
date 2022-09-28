<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratantesTable extends Migration
{
    public function up()
    {
        Schema::create('contratantes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contratantes');
    }
}
