<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaoCreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartao_credito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id')->index('cartao_credito_cliente_id_foreign');
            $table->integer('empresa_id')->nullable();
            $table->string('token_cartao', 60);
            $table->date('vencimento')->nullable();
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
        Schema::dropIfExists('cartao_credito');
    }
}
