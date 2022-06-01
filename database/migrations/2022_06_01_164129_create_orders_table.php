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
        /**
         * The most important thing to know is what sells well and what customer buys it.
         * Where it's bought or who sold it is less important because it doesn't matter in deciding which products to sell.
         */
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('buyer_id')
                ->references('id')->on('buyers')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');

            $table->foreignId('establishment_id')
                ->nullable()
                ->references('id')->on('establishments')
                ->onDelete('set null');

            $table->foreignId('seller_id')
                ->nullable()
                ->references('id')->on('sellers')
                ->onDelete('set null');

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
        Schema::dropIfExists('orders');
    }
}
