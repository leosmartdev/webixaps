<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortSettingFieldsToFeedSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feed_subcategories', function (Blueprint $table) {
            //
            $table->string('sort_by')->default('epc');
            $table->string('sort_order')->default('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_subcategories', function (Blueprint $table) {
            //
            $table->dropColumn('sort_by');
            $table->dropColumn('sort_order');
        });
    }
}
