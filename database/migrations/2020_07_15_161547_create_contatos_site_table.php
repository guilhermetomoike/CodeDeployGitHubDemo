<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos_site', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('usuarios_id')->nullable();
            $table->enum('email_enviado', ['SIM', 'NAO'])->nullable();
            $table->enum('atendido', ['SIM', 'NAO'])->nullable();
            $table->string('telefone_ddd', 2)->nullable();
            $table->string('telefone_numero', 15)->nullable();
            $table->string('email', 45)->nullable();
            $table->timestamps();
            $table->enum('site', ['MEDCONTABIL', 'MEDB'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contatos_site');
    }
}
