<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposOsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_os', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nome_tipo', 55)->nullable();
            $table->enum('tipo', ['TODAS', 'CREDENCIAMENTO', 'FATURAMENTO', 'CERTIDAO', 'RECALCULOGUIA', 'ALTERACAOCONTRATUAL', 'OUTROS', 'DECLARACAORENDIMENTO'])->nullable();
            $table->integer('dias_minimo')->nullable();
            $table->integer('dias_maximo')->nullable();
            $table->decimal('fator_x', 10)->nullable();
            $table->string('titulo', 245)->nullable();
            $table->string('metodo_get', 55)->nullable();
            $table->tinyInteger('ativo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_os');
    }
}
