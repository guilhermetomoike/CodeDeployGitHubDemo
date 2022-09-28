<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFranquiasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franquias_usuarios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('franquias_id')->nullable()->index('fk_franquias_usuarios_franquias_id_idx');
            $table->integer('usuarios_id')->nullable()->index('fk_franquias_usuarios_usuarios_id_idx');
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
        Schema::dropIfExists('franquias_usuarios');
    }
}
