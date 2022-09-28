<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('usuario', 35)->nullable();
            $table->string('nome_completo')->nullable();
            $table->string('senha', 35)->nullable();
            $table->integer('tipo')->nullable();
            $table->date('data_criacao')->nullable();
            $table->tinyInteger('ativo')->nullable();
            $table->string('email', 55)->nullable();
            $table->string('avatar')->nullable();
            $table->string('email_integracao', 245)->nullable();
            $table->string('senha_email', 245)->nullable();
            $table->string('telefone_celular', 25)->nullable();
            $table->string('email_medb', 145)->nullable();
            $table->string('senha_email_medb', 45)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('usuarios');
    }
}
