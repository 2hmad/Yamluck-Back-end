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
            $table->unsignedInteger('gift_id');
            $table->text('title_ar');
            $table->text('title_en');
            $table->unsignedInteger('owner_id')->nullable();
            $table->longText('details_ar');
            $table->longText('details_en');
            $table->text('price');
            $table->text('share_price');
            $table->text('start_date')->nullable();
            $table->text('end_date')->nullable();
            $table->text('max_subs');
            $table->text('curr_subs');
            $table->longText('conditions_ar');
            $table->longText('conditions_en');
            $table->text('category_id');
            $table->text('sub_category_id');
            $table->text('sub_sub_category_id');
            $table->text('pic_one')->nullable();
            $table->text('pic_two')->nullable();
            $table->text('pic_three')->nullable();
            $table->text('pic_four')->nullable();
            $table->text('pic_five')->nullable();
            $table->text('pic_six')->nullable();
            $table->text('country')->nullable();
            $table->text('city')->nullable();
            $table->text('preview')->nullable();
            $table->text('gift_en')->nullable();
            $table->text('gift_ar')->nullable();
            $table->text('gift_pic')->nullable();
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
