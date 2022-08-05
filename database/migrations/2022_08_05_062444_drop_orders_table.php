<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('payments', 'order_number')){
            Schema::table('payments', function (Blueprint $table) {
                $table->dropForeign('order_number');
                $table->dropColumn('order_number');
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::dropIfExists('orders');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    
    }
}
