<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasProlaboresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_prolabores', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('clientes_id')->nullable();
            $table->integer('empresas_id')->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->decimal('prolabore', 10)->nullable();
            $table->decimal('inss')->default(0.00);
            $table->decimal('irrf')->default(0.00);
            $table->string('comprovante', 200)->nullable();
            $table->date('data_competencia')->nullable();
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
        Schema::dropIfExists('empresas_prolabores');
    }
}
