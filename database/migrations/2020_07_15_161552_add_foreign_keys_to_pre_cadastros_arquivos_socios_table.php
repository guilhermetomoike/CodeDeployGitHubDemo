<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreCadastrosArquivosSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_cadastros_arquivos_socios', function (Blueprint $table) {
            $table->foreign('id_socio', 'pre_cadastros_arquivos_socios_ibfk_4')->references('id')->on('pre_cadastros_socios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('id_pre_cadastro', 'pre_cadastros_arquivos_socios_ibfk_5')->references('id')->on('pre_cadastros')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_cadastros_arquivos_socios', function (Blueprint $table) {
            $table->dropForeign('pre_cadastros_arquivos_socios_ibfk_4');
            $table->dropForeign('pre_cadastros_arquivos_socios_ibfk_5');
        });
    }
}
