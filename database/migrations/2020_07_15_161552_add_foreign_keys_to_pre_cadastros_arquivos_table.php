<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreCadastrosArquivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_cadastros_arquivos', function (Blueprint $table) {
            $table->foreign('id_pre_cadastro', 'pre_cadastros_arquivos_ibfk_1')->references('id')->on('pre_cadastros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_cadastros_arquivos', function (Blueprint $table) {
            $table->dropForeign('pre_cadastros_arquivos_ibfk_1');
        });
    }
}
