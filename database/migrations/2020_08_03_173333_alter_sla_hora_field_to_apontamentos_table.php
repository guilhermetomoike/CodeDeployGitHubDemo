<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSlaHoraFieldToApontamentosTable extends Migration
{
    public function up()
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            $table->renameColumn('sla_hora', 'sla');
        });
    }

    public function down()
    {
        Schema::table('apontamentos', function (Blueprint $table) {
            $table->renameColumn('sla', 'sla_hora');
        });
    }
}
