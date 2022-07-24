<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()
            ->has(
                Order::factory()
                    ->has(Branch::factory())
                    ->has(Product::factory()->count(2))
                    ->has(Buyer::factory())
                    ->count(100)
            )
            ->count(10)
            ->create();
    }
}
