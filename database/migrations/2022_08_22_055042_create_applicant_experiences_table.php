<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('job_category_one_id')->nullable();
            $table->unsignedBigInteger('job_category_two_id')->nullable();
            $table->unsignedBigInteger('job_category_three_id')->nullable();
            $table->unsignedBigInteger('job_category_four_id')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('applicant_id')->references('id')->on('applicants')->onDelete('cascade');;
            $table->foreign('job_category_one_id')->references('id')->on('job_category_one');
            $table->foreign('job_category_two_id')->references('id')->on('job_category_two');
            $table->foreign('job_category_three_id')->references('id')->on('job_category_three');
            $table->foreign('job_category_four_id')->references('id')->on('job_category_four');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_experiences');
    }
}
