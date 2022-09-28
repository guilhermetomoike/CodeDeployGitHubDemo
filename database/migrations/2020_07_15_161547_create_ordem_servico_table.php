<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_servico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->nullable()->index('ordem_servico_empresa_id_foreign');
            $table->integer('cliente_id')->nullable()->index('ordem_servico_cliente_id_foreign');
            $table->text('descricao')->nullable();
            $table->integer('usuario_id')->nullable();
            $table->string('motivo_cancelamento')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordem_servico');
    }
}
