<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable2 extends Migration
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
            $table->tinyInteger('card_type')->after('product_payment_id');
            $table->foreignId('applicant_id')
                    ->constrained('applicants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->after('id');
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
            $table->dropColumn('card_type');
            $table->dropConstrainedForeignId('applicant_id');

        });
    }
}
