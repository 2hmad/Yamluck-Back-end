<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('heading_en');
            $table->text('heading_ar');
            $table->text('sub_heading_en')->nullable();
            $table->text('sub_heading_ar')->nullable();
            $table->text('content_en');
            $table->text('content_ar');
            $table->text('btn_text_en')->nullable();
            $table->text('btn_text_ar')->nullable();
            $table->text('btn_redirect')->nullable();
            $table->text('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_settings');
    }
}
