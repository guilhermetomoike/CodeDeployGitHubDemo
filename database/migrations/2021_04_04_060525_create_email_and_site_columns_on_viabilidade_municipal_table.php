<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailAndSiteColumnsOnViabilidadeMunicipalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viabilidade_municipal', function (Blueprint $table) {
            $table->string('modelo_solicitacao_email')->nullable();
            $table->string('nfs_eletronica_manual_site')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viabilidade_municipal', function (Blueprint $table) {
            $table->dropColumn(['modelo_solicitacao_email', 'nfs_eletronica_manual_site']);
        });
    }
}
