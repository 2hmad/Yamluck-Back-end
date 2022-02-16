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
            $table->text('title');
            $table->longText('details');
            $table->text('price');
            $table->text('share_price');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('max_subs');
            $table->text('curr_subs');
            $table->longText('conditions');
            $table->text('category_id');
            $table->text('sub_category_id');
            $table->text('sub_sub_category_id');
            $table->text('pic_one');
            $table->text('pic_two');
            $table->text('pic_three');
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
