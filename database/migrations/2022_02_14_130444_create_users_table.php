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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('full_name');
            $table->text('nick_name')->nullable();
            $table->string('email', 15000)->unique();
            $table->text('phone')->nullable();
            $table->text('country')->nullable();
            $table->text('city')->nullable();
            $table->text('nationality')->nullable();
            $table->text('age')->nullable();
            $table->date('birthdate')->nullable();
            $table->text('interest')->nullable();
            $table->text('password');
            $table->text('facebook_id')->nullable();
            $table->text('twitter_id')->nullable();
            $table->text('apple_id')->nullable();
            $table->text('token');
            $table->text('notifications')->default('Yes');
            $table->text('pic');
            $table->text('verified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
