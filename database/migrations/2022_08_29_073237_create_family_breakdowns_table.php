<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyBreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('visa_type')->nullable;
            $table->string('parent')->nullable;
            $table->string('children')->nullable;
            $table->decimal('cost')->nullable;
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
        Schema::dropIfExists('family_breakdowns');
    }
}
