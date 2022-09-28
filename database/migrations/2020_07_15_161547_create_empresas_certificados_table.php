<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_certificados', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresa_id')->nullable()->index('fk_empresas_certificados_empresas_idx');
            $table->string('senha', 25)->nullable();
            $table->string('arquivo', 245)->nullable();
            $table->date('validade')->nullable();
            $table->string('email', 145)->nullable();
            $table->string('id_integracao', 145)->nullable();
            $table->timestamps();
            $table->string('codigo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_certificados');
    }
}
