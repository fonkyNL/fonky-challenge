<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete();

            $table->foreignId('buyer_id')
                ->nullable()
                ->references('id')
                ->on('buyers')
                ->nullOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->references('id')
                ->on('branches')
                ->nullOnDelete();

            $table->foreignId('employee_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->nullOnDelete();

            $table->timestamp('ordered_at');

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
};
