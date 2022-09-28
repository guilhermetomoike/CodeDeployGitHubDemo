<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrdemServicoAnexosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordem_servico_anexos', function (Blueprint $table) {
            $table->foreign('ordem_servico_id')->references('id')->on('ordem_servico')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordem_servico_anexos', function (Blueprint $table) {
            $table->dropForeign('ordem_servico_anexos_ordem_servico_id_foreign');
        });
    }
}
