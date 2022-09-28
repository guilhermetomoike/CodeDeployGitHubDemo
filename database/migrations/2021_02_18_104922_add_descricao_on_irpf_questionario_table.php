<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescricaoOnIrpfQuestionarioTable extends Migration
{
    public function up()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->string('descricao')->nullable()->after('pergunta');
        });
    }

    public function down()
    {
        Schema::table('irpf_questionario', function (Blueprint $table) {
            $table->dropColumn('descricao');
        });
    }
}
