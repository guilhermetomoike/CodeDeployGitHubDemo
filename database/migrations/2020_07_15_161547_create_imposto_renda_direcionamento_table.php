<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImpostoRendaDirecionamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imposto_renda_direcionamento', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('cpf', 45);
            $table->enum('trabalhou_pf', ['SIM', 'NAO']);
            $table->enum('recibo_pf', ['SIM', 'NAO']);
            $table->enum('obteve_recebimentos', ['SIM', 'NAO']);
            $table->enum('possui_imovel', ['SIM', 'NAO']);
            $table->date('data_imovel')->nullable();
            $table->decimal('valor_imovel', 10)->nullable();
            $table->string('soma_bens', 45)->nullable();
            $table->enum('possui_veiculo', ['SIM', 'NAO']);
            $table->date('data_veiculo')->nullable();
            $table->decimal('valor_veiculo', 10)->nullable();
            $table->enum('proprietario_consorcio', ['SIM', 'NAO']);
            $table->enum('renda_rural', ['SIM', 'NAO']);
            $table->enum('ganho_capital', ['SIM', 'NAO']);
            $table->enum('heranca', ['SIM', 'NAO']);
            $table->enum('pensao', ['SIM', 'NAO']);
            $table->enum('aluguel', ['SIM', 'NAO']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imposto_renda_direcionamento');
    }
}
