<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresaArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_arquivo', function (Blueprint $table) {
            $table->foreign('usuarios_id', 'fk_empresas_arquivos_diversos_usuarios')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_arquivo', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_arquivos_diversos_usuarios');
        });
    }
}
