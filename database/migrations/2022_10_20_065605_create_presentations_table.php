<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('details')->nullable();
            $table->string('document_type')->nullable();
            $table->date('published_date')->nullable();
            $table->text('link_url')->nullable();
            $table->text('image_url')->nullable();
            $table->tinyInteger('active')->nullable()->default(0);

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
        Schema::dropIfExists('presentations');
    }
}
