<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectsEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospects_emails', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('prospects_id')->nullable();
            $table->integer('propostas_medcontabil_id')->nullable();
            $table->integer('usuarios_id')->nullable();
            $table->timestamps();
            $table->enum('email_enviado', ['SIM', 'NAO'])->nullable()->default('SIM');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospects_emails');
    }
}
