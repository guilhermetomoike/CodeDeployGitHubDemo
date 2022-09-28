<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAceitouAndIsentoColumnOnDeclaracaoIrpfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declaracao_irpf', function (Blueprint $table) {
            $table->boolean('aceitou')->nullable()->default(true);
            $table->boolean('isento')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declaracao_irpf', function (Blueprint $table) {
            $table->dropColumn('aceitou');
            $table->dropColumn('isento');
        });
    }
}
