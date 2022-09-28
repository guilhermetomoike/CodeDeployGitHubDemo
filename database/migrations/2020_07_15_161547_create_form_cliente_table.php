<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_cliente', function (Blueprint $table) {
            $table->integer('id_form_cliente', true);
            $table->string('nome_completo', 145);
            $table->string('cpf', 45);
            $table->string('crm', 45);
            $table->char('estado', 2);
            $table->string('instituicao_ensino', 145);
            $table->date('ano_formacao');
            $table->string('especialidade', 145)->nullable();
            $table->enum('meios_comunicacao', ['Internet e Redes Sociais', 'Midia Impressa/Jornais, Revistas e outros', 'Radio', 'Televisao', 'Outros']);
            $table->enum('cursando_residencia', ['Sim', 'Nao']);
            $table->date('conclusao_residencia')->nullable();
            $table->enum('conteudos_relacionados', ['WhatsApp', 'Email']);
            $table->text('medb_representa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_cliente');
    }
}
