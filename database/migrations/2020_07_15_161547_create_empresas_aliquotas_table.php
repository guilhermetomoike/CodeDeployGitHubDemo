<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasAliquotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_aliquotas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable()->index('fk_emrpesas_aliquotas_empresas_idx');
            $table->decimal('aliquota', 10)->nullable();
            $table->integer('fator_r')->nullable();
            $table->date('data_competencia')->nullable();
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
        Schema::dropIfExists('empresas_aliquotas');
    }
}
