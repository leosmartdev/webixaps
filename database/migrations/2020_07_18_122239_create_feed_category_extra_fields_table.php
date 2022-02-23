<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedCategoryExtraFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_category_extra_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feed_category_id')->constrained();
            $table->string('feed_category_field_name');
            $table->string('feed_category_field_type');
            $table->string('feed_category_field_label');
            $table->string('feed_category_field_label_help')->nullable();
            $table->string('feed_category_field_required')->default('no');
            $table->string('feed_category_field_default_value')->nullable();
            $table->text('feed_category_field_options')->nullable();
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
        Schema::dropIfExists('feed_category_extra_fields');
    }
}
