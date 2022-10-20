<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateInvites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_invites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('affiliate_id')->nullable();

            $table->string('invitee_name')->nullable();
            $table->string('invitee_category')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->decimal('product_cost',18,2)->nullable();
            $table->decimal('affiliate_commission',18,2)->nullable();
            $table->date('payment_date')->nullable();

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
        Schema::dropIfExists('affiliate_invites');
    }
}
