<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FeedSiteDeleteCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('campaign_display_settings', function (Blueprint $table) {
        $table->dropForeign('campaign_display_settings_feed_site_id_foreign');
        $table->foreign('feed_site_id')
          ->references('id')
          ->on('feed_sites')
          ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
