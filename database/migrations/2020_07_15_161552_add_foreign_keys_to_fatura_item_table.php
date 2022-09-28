<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToFaturaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fatura_item', function (Blueprint $table) {
            $table->foreign('fatura_id', 'fatura_item_ibfk_1')->references('id')->on('fatura')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fatura_item', function (Blueprint $table) {
            $table->dropForeign('fatura_item_ibfk_1');
        });
    }
}
