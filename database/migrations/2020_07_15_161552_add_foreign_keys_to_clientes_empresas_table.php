<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClientesEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes_empresas', function (Blueprint $table) {
            $table->foreign('clientes_id', 'fk_clientes_has_empresas_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes_empresas', function (Blueprint $table) {
            $table->dropForeign('fk_clientes_has_empresas_clientes1');
        });
    }
}
