<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPlanHasServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_has_service_orders', function (Blueprint $table) {
            $table->foreign('os_base_id')->references('id')->on('os_base')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('plan_id')->references('id')->on('plans')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_has_service_orders', function (Blueprint $table) {
            $table->dropForeign('plan_has_service_orders_os_base_id_foreign');
            $table->dropForeign('plan_has_service_orders_plan_id_foreign');
        });
    }
}
