<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProlaboreClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prolabore_cliente', function (Blueprint $table) {
            $table->foreign('clientes_id', 'prolabore_cliente_ibfk_1')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prolabore_cliente', function (Blueprint $table) {
            $table->dropForeign('prolabore_cliente_ibfk_1');
        });
    }
}
