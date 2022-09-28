<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsavelInPrecadastroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa_pre_cadastros', function (Blueprint $table) {
            $table
                ->unsignedInteger('responsavel_onboarding_id')
                ->nullable()
                ->after('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa_pre_cadastros', function (Blueprint $table) {
            $table->dropColumn('responsavel_onboarding_id');
        });
    }
}
