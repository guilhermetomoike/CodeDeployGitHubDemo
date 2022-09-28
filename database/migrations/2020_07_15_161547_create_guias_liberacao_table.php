<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasLiberacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias_liberacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->index('guias_liberacao_empresa_id_foreign');
            $table->date('competencia');
            $table->boolean('financeiro_departamento_liberacao')->default(0);
            $table->boolean('rh_departamento_liberacao')->default(0);
            $table->boolean('contabilidade_departamento_liberacao')->default(0);
            $table->boolean('congelado')->default(0);
            $table->dateTime('data_envio')->nullable();
            $table->boolean('erro_envio')->nullable()->default(0);
            $table->timestamps();
            $table->boolean('sem_guia')->default(0);
            $table->text('error_message')->nullable();
            $table->boolean('liberado')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guias_liberacao');
    }
}
