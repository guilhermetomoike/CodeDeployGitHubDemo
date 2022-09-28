<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePalestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('palestras', function (Blueprint $table) {
            $table->integer('id_palestra', true);
            $table->string('nome_palestra', 145)->nullable();
            $table->string('nome_palestrante', 145)->nullable();
            $table->string('nome_faculdade', 145)->nullable();
            $table->string('local', 145)->nullable();
            $table->string('cidade', 145)->nullable();
            $table->char('estado', 2)->nullable();
            $table->string('hora', 45)->nullable();
            $table->date('data_palestra')->nullable();
            $table->tinyInteger('disponivel')->nullable();
            $table->dateTime('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('palestras');
    }
}
