<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCategoryTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_category_two', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_category_one_id');

            $table->string('name')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_category_one_id')->references('id')->on('job_category_one');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_category_two');
    }
}
