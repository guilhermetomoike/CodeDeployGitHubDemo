<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVendasUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendas_usuario', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendas_usuario', function (Blueprint $table) {
            $table->dropForeign('vendas_usuario_cliente_id_foreign');
            $table->dropForeign('vendas_usuario_empresa_id_foreign');
            $table->dropForeign('vendas_usuario_usuario_id_foreign');
        });
    }
}
