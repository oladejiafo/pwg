<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCategoryThreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_category_three', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_category_two_id');
            $table->string('name')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_category_two_id')->references('id')->on('job_category_two');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_category_three');
    }
}
