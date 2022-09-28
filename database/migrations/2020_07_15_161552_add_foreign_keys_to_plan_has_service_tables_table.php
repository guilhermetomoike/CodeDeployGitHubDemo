<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPlanHasServiceTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_has_service_tables', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('service_table_id')->references('id')->on('service_tables')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_has_service_tables', function (Blueprint $table) {
            $table->dropForeign('plan_has_service_tables_plan_id_foreign');
            $table->dropForeign('plan_has_service_tables_service_table_id_foreign');
        });
    }
}
