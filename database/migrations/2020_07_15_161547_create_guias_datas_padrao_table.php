<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasDatasPadraoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias_datas_padrao', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->enum('tipo', ['HOLERITE', 'DAS', 'PIS', 'COFINS', 'IRPJ', 'CSLL', 'ISS', 'FGTS', 'IRRF', 'INSS', 'HONORARIOS'])->nullable();
            $table->timestamps();
            $table->date('data_vencimento')->default('2020-06-22');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guias_datas_padrao');
    }
}
