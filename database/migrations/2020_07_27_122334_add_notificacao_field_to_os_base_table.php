<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificacaoFieldToOsBaseTable extends Migration
{
    public function up()
    {
        Schema::table('os_base', function (Blueprint $table) {
            $table->boolean('notificacao');
        });
    }

    public function down()
    {
        Schema::table('os_base', function (Blueprint $table) {
            $table->dropColumn('notificacao');
        });
    }
}
