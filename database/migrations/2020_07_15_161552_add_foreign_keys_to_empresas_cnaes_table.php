<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToEmpresasCnaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas_cnaes', function (Blueprint $table) {
            $table->foreign('empresa_id', 'fk_empresas_cnaes_empresas')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas_cnaes', function (Blueprint $table) {
            $table->dropForeign('fk_empresas_cnaes_empresas');
        });
    }
}
