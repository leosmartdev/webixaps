<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClickEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained();
            $table->string('campaign_country');
            $table->string('campaign_feed_category');
            $table->string('campaign_affiliate_network');
            $table->string('client_ip_address')->nullable();
            $table->string('client_country')->nullable();
            $table->string('client_region')->nullable();
            $table->string('client_city')->nullable();
            $table->string('client_platform')->nullable();
            $table->string('click_type')->default('Unique');
            $table->string('click_source_site_url')->nullable();
            $table->string('click_source_site_name')->nullable();
            $table->string('click_source_site_domain')->nullable();
            $table->string('click_destination')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('keyword')->nullable();
            $table->decimal('payout', 15, 8)->nullable();
            $table->string('currency')->nullable();
            $table->string('parameters')->nullable();
            $table->string('conversion_status')->default('Pending');
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
        Schema::dropIfExists('click_events');
    }
}
