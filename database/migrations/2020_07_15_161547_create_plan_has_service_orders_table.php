<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanHasServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_has_service_orders', function (Blueprint $table) {
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('os_base_id')->index('plan_has_service_orders_os_base_id_foreign');
            $table->unsignedBigInteger('plan_id')->index('plan_has_service_orders_plan_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_has_service_orders');
    }
}
