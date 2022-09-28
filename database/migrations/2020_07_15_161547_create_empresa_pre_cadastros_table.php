<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaPreCadastrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_pre_cadastros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('empresa');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('empresa_id')->nullable();
            $table->timestamps();
            $table->enum('tipo', ['abertura', 'transferencia']);
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
        Schema::dropIfExists('empresa_pre_cadastros');
    }
}
