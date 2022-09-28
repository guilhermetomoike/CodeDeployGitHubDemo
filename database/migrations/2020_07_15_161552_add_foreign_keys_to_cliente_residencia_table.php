<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClienteResidenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cliente_residencia', function (Blueprint $table) {
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
        Schema::table('cliente_residencia', function (Blueprint $table) {
            $table->dropForeign('cliente_residencia_cliente_id_foreign');
            $table->dropForeign('cliente_residencia_empresa_id_foreign');
            $table->dropForeign('cliente_residencia_usuario_id_foreign');
        });
    }
}
