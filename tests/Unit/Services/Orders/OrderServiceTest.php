<?php

namespace Tests\Unit\Services\Orders;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use App\Services\Orders\OrderService;
use Illuminate\Database\QueryException;
use Tests\TestCase;

/** @group Services\OrderServiceTest */
class OrderServiceTest extends TestCase
{
    public function testItCanCreateAnOrder()
    {
        $order = (new OrderService())
            ->forCustomer('Test')
            ->createOrder(now());

        $this->assertModelExists($order);
    }

    public function testItNeedsACustomerWhenCreatingAnOrder()
    {
        $this->expectException(QueryException::class);

        $order = (new OrderService())
            ->createOrder(now());

        $this->assertModelMissing($order);
    }

    public function testItCreatesATheModelsIfTheyDoesNotYetExist()
    {
        $order = (new OrderService())
            ->forCustomer('TestCustomer')
            ->atBranch('TestBranch')
            ->soldBy('TestEmployee')
            ->boughtBy('TestBuyer')
            ->createOrder(now());

        $this->assertDatabaseHas('customers', ['name' => 'TestCustomer']);
        $this->assertDatabaseHas('branches', ['name' => 'TestBranch']);
        $this->assertDatabaseHas('employees', ['name' => 'TestEmployee']);
        $this->assertDatabaseHas('buyers', ['name' => 'TestBuyer']);
    }

    public function testItUsesTheExistingCustomerWhenPassed()
    {
        $customer = Customer::factory()->create();
        $branch = Branch::factory()->create();
        $employee = Employee::factory()->create();
        $buyer = Buyer::factory()->create();

        $order = (new OrderService())
            ->forCustomer($customer)
            ->atBranch($branch)
            ->soldBy($employee)
            ->boughtBy($buyer)
            ->createOrder(now());

        $this->assertDatabaseCount('customers', 1);
        $this->assertDatabaseCount('branches', 1);
        $this->assertDatabaseCount('employees', 1);
        $this->assertDatabaseCount('buyers', 1);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'customer_id' => $customer->id,
            'branch_id' => $branch->id,
            'employee_id' => $employee->id,
            'buyer_id' => $buyer->id,
        ]);
    }
}
