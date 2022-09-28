<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToInvitesTable extends Migration
{
    public function up()
    {
        Schema::table('invites', function (Blueprint $table) {
            $table->integer('customer_id')->nullable()->after('id');
            $table->string('customer_email')->nullable()->change();
            $table->integer('ploomes_id')->nullable()->after('invitee_phone');
            $table->integer('ploomes_deal_id')->nullable()->after('ploomes_id');
            $table->string('status')->after('invitee_phone')->default(\App\Models\Invite::STATUS_RECEBIDO);

            $table->foreign('customer_id')->references('id')->on('clientes');
        });
    }

    public function down()
    {
        Schema::table('invites', function (Blueprint $table) {
            //
        });
    }
}
