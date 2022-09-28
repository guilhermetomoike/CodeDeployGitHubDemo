<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanHasServiceTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_has_service_tables', function (Blueprint $table) {
            $table->unsignedBigInteger('service_table_id')->index('plan_has_service_tables_service_table_id_foreign');
            $table->unsignedBigInteger('plan_id')->index('plan_has_service_tables_plan_id_foreign');
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists('plan_has_service_tables');
    }
}
