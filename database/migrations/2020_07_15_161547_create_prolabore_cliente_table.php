<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProlaboreClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prolabore_cliente', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('clientes_id')->nullable()->index('clientes_id');
            $table->decimal('prolabore', 10)->nullable();
            $table->date('data_competencia')->nullable();
            $table->timestamps();
            $table->string('cnpj', 14)->nullable();
            $table->decimal('irrf')->nullable();
            $table->decimal('inss')->nullable();
            $table->string('comprovante', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prolabore_cliente');
    }
}
