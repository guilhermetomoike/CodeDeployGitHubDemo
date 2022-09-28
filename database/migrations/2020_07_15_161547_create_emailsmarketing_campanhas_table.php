<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsmarketingCampanhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emailsmarketing_campanhas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('clientes_id');
            $table->string('email_cliente', 45);
            $table->timestamp('created_at')->useCurrent();
            $table->enum('email_enviado', ['ENVIADO', 'PENDENTE']);
            $table->string('campanha', 45);
            $table->string('nome', 245);
            $table->timestamp('enviado_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emailsmarketing_campanhas');
    }
}
