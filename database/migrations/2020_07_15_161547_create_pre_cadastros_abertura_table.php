<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCadastrosAberturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cadastros_abertura', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_pre_cadastro')->nullable()->index('id_pre_cadastro');
            $table->enum('tipo_societario', ['Eireli', 'LTDA'])->nullable();
            $table->enum('tipo_estabelecimento', ['F', 'P'])->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_cadastros_abertura');
    }
}
