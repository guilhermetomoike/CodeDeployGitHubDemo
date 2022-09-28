<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteArquivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_arquivo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientes_id')->nullable();
            $table->string('nome', 100)->nullable();
            $table->string('pasta', 300)->nullable();
            $table->string('tipo_arquivo', 50)->nullable();
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
        Schema::dropIfExists('cliente_arquivo');
    }
}
