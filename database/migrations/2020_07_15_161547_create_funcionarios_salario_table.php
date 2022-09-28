<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosSalarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios_salario', function (Blueprint $table) {
            $table->integer('funcionario_id');
            $table->integer('empresa_id');
            $table->dateTime('dt_salario');
            $table->dateTime('dt_final');
            $table->decimal('vl_salario');
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
        Schema::dropIfExists('funcionarios_salario');
    }
}
