<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicantsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("applicants", function (Blueprint $table)
        {
            // $table->foreignId('product_id')
            //         ->constrained('products')
            //         ->onUpdate('cascade')
            //         ->onDelete('cascade')
            //         ->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("applicants", function (Blueprint $table)
        {
            $table->dropConstrainedForeignId('product_id');
        });
    }
}
