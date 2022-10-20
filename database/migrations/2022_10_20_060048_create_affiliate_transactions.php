<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable();

            $table->decimal('amount',18,2)->nullable();
            $table->string('transaction_type')->nullable();
            $table->date('transaction_date')->nullable();
            $table->decimal('balance',18,2)->nullable();
            $table->text('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('swift_code')->nullable();

            $table->foreign('affiliate_id')->references('id')->on('affiliate');
            $table->foreign('bank_account_id')->references('id')->on('affiliate_bank_account');

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
        Schema::dropIfExists('affiliate_transactions');
    }
}
