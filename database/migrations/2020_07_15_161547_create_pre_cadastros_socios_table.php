<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros_socios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_pre_cadastro')->nullable()->index('id_pre_cadastro');
            $table->string('nome')->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('rg', 14)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefone', 25)->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->string('estado_civil', 25)->nullable();
            $table->string('profissao', 100)->nullable();
            $table->string('nacionalidade', 50)->nullable();
            $table->double('procentagem', 10, 2)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero', 7)->nullable();
            $table->string('bairro', 145)->nullable();
            $table->string('cidade', 145)->nullable();
            $table->char('uf', 2)->nullable();
            $table->string('complemento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros_socios');
    }
}
