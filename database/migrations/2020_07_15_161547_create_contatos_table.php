<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tipo', ['email', 'celular']);
            $table->string('value');
            $table->boolean('optin');
            $table->json('options')->nullable();
            $table->timestamps();
            $table->string('contactable_type')->nullable();
            $table->unsignedBigInteger('contactable_id')->nullable();
            $table->index(['contactable_type', 'contactable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contatos');
    }
}
