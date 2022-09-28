<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_usuario', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('clientes_id')->index('fk_clientes_has_usuarios_clientes1_idx');
            $table->integer('usuarios_id')->index('fk_clientes_has_usuarios_usuarios1_idx');
            $table->date('data_cadastro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_usuario');
    }
}
