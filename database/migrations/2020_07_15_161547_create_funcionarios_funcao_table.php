<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosFuncaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios_funcao', function (Blueprint $table) {
            $table->integer('funcionario_id');
            $table->integer('empresa_id');
            $table->dateTime('dt_funcao');
            $table->integer('funcao_id');
            $table->dateTime('dt_final');
            $table->string('funcao', 200);
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
        Schema::dropIfExists('funcionarios_funcao');
    }
}
