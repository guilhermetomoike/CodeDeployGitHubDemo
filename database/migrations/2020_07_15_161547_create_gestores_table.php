<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGestoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gestores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome_gestor', 45)->nullable();
            $table->integer('id_usuarios')->nullable()->index('fk_gestores_usuarios_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gestores');
    }
}
