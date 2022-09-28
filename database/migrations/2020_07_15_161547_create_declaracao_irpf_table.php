<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclaracaoIrpfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declaracao_irpf', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id')->index('declaracao_irpf_cliente_id_foreign');
            $table->year('ano');
            $table->string('declaracao')->nullable();
            $table->string('recibo')->nullable();
            $table->enum('realizacao', ['isento', 'externo', 'interno']);
            $table->text('observacao')->nullable();
            $table->json('conta_restituicao')->nullable();
            $table->enum('step', ['questionario', 'pendencia', 'comprovante', 'finalizado'])->default('questionario');
            $table->timestamps();
            $table->tinyInteger('qtd_lancamento');
            $table->dateTime('enviado')->nullable();
            $table->boolean('rural')->nullable();
            $table->boolean('ganho_captal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declaracao_irpf');
    }
}
