<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_bancarias', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('bancos_cod')->nullable()->index('fk_contas_bancarias_bancos_idx');
            $table->integer('empresas_id')->nullable()->index('fk_contas_bancarias_empresas_idx');
            $table->integer('clientes_id')->nullable()->index('fk_contas_bancarias_clientes_idx');
            $table->string('digito', 3)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('agencia', 6)->nullable();
            $table->enum('tipo', ['P', 'C'])->nullable();
            $table->enum('pessoa', ['PF', 'PJ'])->nullable();
            $table->enum('conta_padrao', ['SIM', 'NAO'])->nullable();
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
        Schema::dropIfExists('contas_bancarias');
    }
}
