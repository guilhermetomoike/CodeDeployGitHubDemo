<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApontamentosTable extends Migration
{
    public function up()
    {
        Schema::create('apontamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome');
            $table->integer('sla_hora');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apontamentos');
    }
}
