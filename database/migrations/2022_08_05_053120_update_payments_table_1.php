<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("payments", function (Blueprint $table) 
        {
            $table->foreignId('product_payment_id')
                    ->constrained('product_payments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->after('order_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("payments", function (Blueprint $table) 
        {
            $table->dropConstrainedForeignId('product_payment_id');
        });
    }
}
