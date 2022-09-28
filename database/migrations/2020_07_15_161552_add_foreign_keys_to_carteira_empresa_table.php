<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCarteiraEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carteira_empresa', function (Blueprint $table) {
            $table->foreign('carteira_id')->references('id')->on('carteiras')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carteira_empresa', function (Blueprint $table) {
            $table->dropForeign('carteira_empresa_carteira_id_foreign');
            $table->dropForeign('carteira_empresa_empresa_id_foreign');
        });
    }
}
