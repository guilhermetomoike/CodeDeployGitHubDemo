<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappMessageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_message_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('direction', ['outgoing', 'incomming']);
            $table->string('from', 50);
            $table->string('to', 50);
            $table->mediumText('text');
            $table->text('media')->nullable();
            $table->json('payload');
            $table->softDeletes();
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
        Schema::dropIfExists('whatsapp_message_logs');
    }
}
