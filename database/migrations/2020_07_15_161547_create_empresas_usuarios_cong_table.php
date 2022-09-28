<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasUsuariosCongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_usuarios_cong', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->index('fk_empresas_has_usuarios_empresas3_idx');
            $table->integer('usuarios_id')->index('fk_empresas_has_usuarios_usuarios3_idx');
            $table->tinyInteger('congelada')->nullable();
            $table->date('data_congelamento')->nullable();
            $table->date('data_competencia')->nullable();
            $table->string('motivo_congelamento', 150)->nullable();
            $table->date('previsao_retorno')->nullable();
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
        Schema::dropIfExists('empresas_usuarios_cong');
    }
}
