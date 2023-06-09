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
            $table->foreignId('application_id')
                ->constrained('applicants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('product_payment_id');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->integer('month');
            $table->year('year');
            $table->integer('cvv');
            $table->decimal('total');
            $table->string('currency_code')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('card_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('payments', function($table) {
            $table->string('payment_type')->after('transaction_id');
            $table->integer('save_card_info')->after('payment_type');
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
