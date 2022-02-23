<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_networks', function (Blueprint $table) {
            $table->id();
            $table->string('affiliate_network_name');
            $table->string('affiliate_network_parameter');
            $table->timestamps();
        });


        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('country_id');
            $table->string('country_name');
            $table->string('feed_category_id');
            $table->string('feed_category_name');
            $table->string('clean_url');
            $table->string('landing_page_url');
            $table->string('affiliate_network_url');
            $table->string('campaign_logo');
            $table->string('campaign_banner_small')->nullable();
            $table->string('campaign_banner_medium')->nullable();
            $table->string('campaign_banner_large')->nullable();
            $table->string('campaign_ribbon')->nullable();
            $table->text('campaign_extra_field_value')->nullable();
            $table->foreignId('affiliate_network_id')->constrained();
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
        Schema::dropIfExists('affiliate_networks');
        Schema::dropIfExists('campaigns');
    }
}
