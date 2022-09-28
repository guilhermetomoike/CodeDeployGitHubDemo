<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToArquivosAberturaEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arquivos_abertura_empresa', function (Blueprint $table) {
            $table->foreign('pre_cadastro_id', 'pre_cadastro_id')->references('id')->on('pre_cadastros')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('status_id', 'statusId')->references('id')->on('status_abertura_empresa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arquivos_abertura_empresa', function (Blueprint $table) {
            $table->dropForeign('pre_cadastro_id');
            $table->dropForeign('statusId');
        });
    }
}
