<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('titulo', 100)->nullable();
            $table->string('texto', 545);
            $table->date('data_criacao')->nullable();
            $table->integer('usuarios_id')->index('fk_notas_usuarios1_idx');
            $table->date('data_retorno')->nullable();
            $table->integer('empresas_id')->nullable()->index('fk_notas_empresas_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas');
    }
}
