<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertidoesNegativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certidoes_negativas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->index('certidoes_negativas_empresa_id_foreign');
            $table->string('tipo');
            $table->date('data_emissao');
            $table->date('data_validade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certidoes_negativas');
    }
}
