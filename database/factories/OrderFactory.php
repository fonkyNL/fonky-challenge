<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'branch_id' => Branch::factory(),
            'employee_id' => Employee::factory(),
            'buyer_id' => Buyer::factory(),
            'ordered_at' => now(),
        ];
    }
}
