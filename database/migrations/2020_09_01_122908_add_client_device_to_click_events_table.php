<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientDeviceToClickEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('click_events', function (Blueprint $table) {
            //
            $table->string('client_device')->nullable();
            $table->string('client_browser')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('click_events', function (Blueprint $table) {
            //
            $table->dropColumn('client_device');
            $table->dropColumn('client_browser');
        });
    }
}
