<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreCadastrosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_cadastros_usuarios', function (Blueprint $table) {
            $table->foreign('id_pre_cadastro', 'pre_cadastros_usuarios_ibfk_1')->references('id')->on('pre_cadastros')->onUpdate('RESTRICT')->onDelete('NO ACTION');
            $table->foreign('id_usuario', 'pre_cadastros_usuarios_ibfk_2')->references('id')->on('usuarios')->onUpdate('RESTRICT')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_cadastros_usuarios', function (Blueprint $table) {
            $table->dropForeign('pre_cadastros_usuarios_ibfk_1');
            $table->dropForeign('pre_cadastros_usuarios_ibfk_2');
        });
    }
}
