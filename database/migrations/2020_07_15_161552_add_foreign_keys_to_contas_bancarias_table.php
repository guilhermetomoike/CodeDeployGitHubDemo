<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToContasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas_bancarias', function (Blueprint $table) {
            $table->foreign('bancos_cod', 'fk_contas_bancarias_bancos')->references('cod')->on('bancos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('clientes_id', 'fk_contas_bancarias_clientes')->references('id')->on('clientes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contas_bancarias', function (Blueprint $table) {
            $table->dropForeign('fk_contas_bancarias_bancos');
            $table->dropForeign('fk_contas_bancarias_clientes');
        });
    }
}
