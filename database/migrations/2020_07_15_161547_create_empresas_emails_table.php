<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_emails', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('empresas_id')->nullable();
            $table->integer('usuarios_id')->nullable();
            $table->string('email', 145)->nullable();
            $table->string('whatsapp', 11)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas_emails');
    }
}
