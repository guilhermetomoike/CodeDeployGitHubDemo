<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToParticipantesPalestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participantes_palestras', function (Blueprint $table) {
            $table->foreign('palestras_id', 'fk_participantes_palestras_palestras')->references('id_palestra')->on('palestras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participantes_palestras', function (Blueprint $table) {
            $table->dropForeign('fk_participantes_palestras_palestras');
        });
    }
}
