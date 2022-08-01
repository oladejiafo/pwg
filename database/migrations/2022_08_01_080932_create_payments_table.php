<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->foreign('order_number')->references('order_number')->on('orders')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->integer('month');
            $table->year('year');
            $table->integer('cvv');
            $table->decimal('total');
            $table->string('currency_code')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('transaction_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('payments');
    }
}
