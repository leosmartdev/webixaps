<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CampaignFeedSubcategoriesDeleteCascade extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('campaign_feed_subcategories', function (Blueprint $table) {
        $table->dropForeign('campaign_feed_subcategories_feed_subcategory_id_foreign');
        $table->foreign('feed_subcategory_id')
          ->references('id')
          ->on('feed_subcategories')
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
