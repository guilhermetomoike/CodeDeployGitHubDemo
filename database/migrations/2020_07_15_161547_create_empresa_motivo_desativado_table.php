<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaMotivoDesativadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_motivo_desativado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('motivo', 100);
            $table->string('descricao')->nullable();
            $table->integer('usuario_id')->nullable()->index('empresa_motivo_desativado_usuario_id_foreign');
            $table->integer('empresa_id')->index('empresa_motivo_desativado_empresa_id_foreign');
            $table->timestamps();
            $table->date('data_competencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa_motivo_desativado');
    }
}
