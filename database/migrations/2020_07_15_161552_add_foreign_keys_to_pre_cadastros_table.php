<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreCadastrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_cadastros', function (Blueprint $table) {
            $table->foreign('empresa_id', 'pre_cadastros_ibfk_1')->references('id')->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('status_id', 'status_id')->references('id')->on('status_abertura_empresa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_cadastros', function (Blueprint $table) {
            $table->dropForeign('pre_cadastros_ibfk_1');
            $table->dropForeign('status_id');
        });
    }
}
