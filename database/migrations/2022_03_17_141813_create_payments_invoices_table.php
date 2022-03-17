<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('user_id');
            $table->text('invoice_id');
            $table->text('bill_to');
            $table->text('payment');
            $table->date('order_date');
            $table->text('description');
            $table->text('publisher')->default('Yammluck');
            $table->text('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments_invoices');
    }
}
