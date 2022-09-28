<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas_usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->nullable()->index('vendas_usuario_empresa_id_foreign');
            $table->integer('cliente_id')->index('vendas_usuario_cliente_id_foreign');
            $table->integer('usuario_id')->index('vendas_usuario_usuario_id_foreign');
            $table->decimal('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas_usuario');
    }
}
