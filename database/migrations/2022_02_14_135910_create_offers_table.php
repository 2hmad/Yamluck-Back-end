<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title_ar');
            $table->text('title_en');
            $table->longText('details_ar');
            $table->longText('details_en');
            $table->text('price');
            $table->text('share_price');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('max_subs');
            $table->text('curr_subs');
            $table->longText('conditions_ar');
            $table->longText('conditions_en');
            $table->text('category_id');
            $table->text('sub_category_id');
            $table->text('sub_sub_category_id');
            $table->text('pic_one');
            $table->text('pic_two');
            $table->text('pic_three');
            $table->text('video_link')->nullable();
            $table->date('publish_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
