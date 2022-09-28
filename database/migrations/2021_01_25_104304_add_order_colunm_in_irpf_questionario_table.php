<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderColunmInIrpfQuestionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->tinyInteger('order')->nullable();
            $table->boolean('ativo')->default(1);
        });
    }

    public function down()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->dropColumn('order', 'ativo');
        });
    }
}
