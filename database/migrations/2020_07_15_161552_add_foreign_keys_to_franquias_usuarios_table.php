<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFranquiasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franquias_usuarios', function (Blueprint $table) {
            $table->foreign('franquias_id', 'fk_franquias_usuarios_franquias_id')->references('id')->on('franquias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('usuarios_id', 'fk_franquias_usuarios_usuarios_id')->references('id')->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('franquias_usuarios', function (Blueprint $table) {
            $table->dropForeign('fk_franquias_usuarios_franquias_id');
            $table->dropForeign('fk_franquias_usuarios_usuarios_id');
        });
    }
}
