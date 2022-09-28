<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreCadastrosPropostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_cadastros_proposta', function (Blueprint $table) {
            $table->foreign('id_plano', 'pre_cadastros_proposta_ibfk_2')->references('id')->on('planos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('id_pre_cadastro', 'pre_cadastros_proposta_ibfk_3')->references('id')->on('pre_cadastros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_cadastros_proposta', function (Blueprint $table) {
            $table->dropForeign('pre_cadastros_proposta_ibfk_2');
            $table->dropForeign('pre_cadastros_proposta_ibfk_3');
        });
    }
}
