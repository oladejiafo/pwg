<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbooks', function (Blueprint $table) {
            $table->id();
            $table->text('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('realmId')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('refresh_token_expires_in')->nullable();
            $table->string('access_token_expires_in')->nullable();
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
        Schema::dropIfExists('quickbooks');
    }
}