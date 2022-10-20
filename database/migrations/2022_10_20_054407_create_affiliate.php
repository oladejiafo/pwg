<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate', function (Blueprint $table) {
            $table->id();

            $table->string('refferer_code')->nullable();

            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email', 64)->unique()->nullable();
            $table->string('phone_number', 30)->unique()->nullable();
            $table->string('sex')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('country_of_residence')->nullable();

            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('residence_id')->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry')->nullable();

            $table->string('password')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliate');
    }
}
