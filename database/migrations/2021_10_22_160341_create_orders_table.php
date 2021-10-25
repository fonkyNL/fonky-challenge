<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id');
            $table->integer('orderId')->unique();
            $table->string('koper');
            $table->timestamp('orderdatum');
            $table->string('productId');
            $table->string('vestiging');
            $table->string('verkoper');
            $table->timestamp('updatedAt')->useCurrentOnUpdate()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('createdAt')->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
