<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCategoryFoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_category_four', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_category_three_id');

            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('example_titles')->nullable();
            $table->longText('main_duties')->nullable();
            $table->longText('employement_requirements')->nullable();
            // $table->longText('additional_information')->nullable();
            // $table->longText('exclusions')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_category_three_id')->references('id')->on('job_category_three');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_category_four');
    }
}
