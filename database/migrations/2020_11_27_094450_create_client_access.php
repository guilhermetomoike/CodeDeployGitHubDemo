<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_access', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('login', 45)->nullable();
            $table->string('password', 45)->nullable();
            $table->string('url', 405)->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_access');
    }
}
