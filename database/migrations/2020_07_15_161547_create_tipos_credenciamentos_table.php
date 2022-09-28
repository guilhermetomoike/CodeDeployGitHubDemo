<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposCredenciamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_credenciamentos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome', 55)->nullable();
            $table->string('descricao_emissao', 145)->nullable();
            $table->string('descricao_recebimento', 145)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_credenciamentos');
    }
}
