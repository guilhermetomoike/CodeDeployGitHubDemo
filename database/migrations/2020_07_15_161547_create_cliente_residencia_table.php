<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteResidenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_residencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id')->nullable()->index('cliente_residencia_empresa_id_foreign');
            $table->integer('cliente_id')->index('cliente_residencia_cliente_id_foreign');
            $table->integer('usuario_id')->nullable()->index('cliente_residencia_usuario_id_foreign');
            $table->string('comprovante')->nullable();
            $table->string('especialidade');
            $table->date('data_inicio');
            $table->date('data_conclusao');
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
        Schema::dropIfExists('cliente_residencia');
    }
}
