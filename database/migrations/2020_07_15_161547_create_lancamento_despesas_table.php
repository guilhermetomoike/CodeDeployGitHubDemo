<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentoDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamento_despesas', function (Blueprint $table) {
            $table->integer('Id', true);
            $table->string('tipo', 80)->nullable();
            $table->date('data_criado')->nullable();
            $table->decimal('valor', 18)->nullable();
            $table->text('descricao')->nullable();
            $table->integer('parcela')->nullable();
            $table->string('arquivo', 100)->nullable();
            $table->integer('situacao')->nullable()->default(0);
            $table->integer('clientes_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamento_despesas');
    }
}
