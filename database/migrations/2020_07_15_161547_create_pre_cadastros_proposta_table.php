<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosPropostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros_proposta', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedInteger('id_plano')->nullable()->index('id_plano');
            $table->integer('qtde')->nullable();
            $table->integer('id_pre_cadastro')->index('id_pre_cadastro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros_proposta');
    }
}
