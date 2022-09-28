<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToClienteUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cliente_usuario', function (Blueprint $table) {
            $table->foreign('clientes_id', 'fk_clientes_has_usuarios_clientes1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuarios_id', 'fk_clientes_has_usuarios_usuarios1')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cliente_usuario', function (Blueprint $table) {
            $table->dropForeign('fk_clientes_has_usuarios_clientes1');
            $table->dropForeign('fk_clientes_has_usuarios_usuarios1');
        });
    }
}
