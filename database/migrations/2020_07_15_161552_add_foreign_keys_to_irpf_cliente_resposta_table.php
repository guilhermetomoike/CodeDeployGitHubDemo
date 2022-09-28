<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToIrpfClienteRespostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irpf_cliente_resposta', function (Blueprint $table) {
            $table->foreign('cliente_id')->references('id')->on('clientes')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('irpf_questionario_id')->references('id')->on('irpf_questionario')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irpf_cliente_resposta', function (Blueprint $table) {
            $table->dropForeign('irpf_cliente_resposta_cliente_id_foreign');
            $table->dropForeign('irpf_cliente_resposta_irpf_questionario_id_foreign');
        });
    }
}
