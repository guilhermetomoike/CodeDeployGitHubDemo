<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasRegimeTributarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_regime_tributario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable()->index('fk_regime_tributario_empresas_idx');
            $table->enum('regime_tributario', ['SN', 'Presumido'])->nullable();
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
        Schema::dropIfExists('empresas_regime_tributario');
    }
}
