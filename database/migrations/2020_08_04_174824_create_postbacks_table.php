<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained();
            $table->foreignId('click_event_id')->constrained();
            $table->foreignId('affiliate_network_id')->constrained();
            $table->string('currency')->default('DKK');
            $table->decimal('payout', 15, 8)->nullable();
            $table->decimal('commission', 15, 8)->nullable();
            $table->string('status')->default('Accepted');
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
        Schema::dropIfExists('postbacks');
    }
}
