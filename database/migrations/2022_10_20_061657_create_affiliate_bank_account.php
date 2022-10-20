<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //affiliate_bank_account
        Schema::create('affiliate_bank_account', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->nullable();

            $table->string('account_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('bank_address')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('account_number_iban')->nullable();
            $table->string('swift_code')->nullable();

            $table->foreign('affiliate_id')->references('id')->on('affiliate');

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
        Schema::dropIfExists('affiliate_bank_account');
    }
}
