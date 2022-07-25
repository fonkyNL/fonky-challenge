<?php

namespace Tests\Unit\Services;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use stdClass;
use Tests\TestCase;

/** @group Services\CustomerServiceTest */
class OrderServiceTest extends TestCase
{
    public function testTotalOrdersByProductsReturnsATotal()
    {
        $product = Product::factory()->create(['name' => 'D10']);

        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
                    ->hasAttached($product)
            )
            ->create();

        $result = OrderService::totalOrdersByProduct($customer);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]->total);
        $this->assertEquals('D10', $result[0]->name);
    }

    public function testTotalOrdersByProductAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        OrderService::totalOrdersByProduct($customer, 2020);

        $queryLog = DB::getQueryLog();

        $this->assertStringContainsString(
            'date(`orders`.`ordered_at`) >= ? and date(`orders`.`ordered_at`) <= ?',
            $queryLog[0]['query']
        );
    }

    public function testTotalOrdersByProductCachesTheResult()
    {
        $customer = Customer::factory()->create();

        Cache::shouldReceive('remember')
            ->withSomeOfArgs(
                "customers.$customer->id.statistics.2022.total_orders_by_product",
                config('cache.ttl.customers.statistics'))
            ->once()
            ->andReturn(collect());

        OrderService::totalOrdersByProduct($customer, 2022);
    }

    public function testTotalOrdersByBranchReturnsATotal()
    {
        $branch = Branch::factory()->create(['name' => 'Utrecht']);

        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
                    ->for($branch)
            )
            ->create();

        $result = OrderService::totalOrdersByBranch($customer);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]->total);
        $this->assertEquals('Utrecht', $result[0]->name);
    }

    public function testTotalOrdersByBranchAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        OrderService::totalOrdersByBranch($customer, 2020);

        $queryLog = DB::getQueryLog();

        $this->assertStringContainsString(
            'date(`orders`.`ordered_at`) >= ? and date(`orders`.`ordered_at`) <= ?',
            $queryLog[0]['query']
        );
    }

    public function testTotalOrdersByBranchCachesTheResult()
    {
        $customer = Customer::factory()->create();

        Cache::shouldReceive('remember')
            ->withSomeOfArgs(
                "customers.$customer->id.statistics.2022.total_orders_by_branch",
                config('cache.ttl.customers.statistics'))
            ->once()
            ->andReturn(collect());

        OrderService::totalOrdersByBranch($customer, 2022);
    }

    public function testTotalOrdersReturnsATotal()
    {
        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
            )
            ->create();

        $result = OrderService::totalOrders($customer);

        $this->assertEquals(2, $result->total);
    }

    public function testTotalOrdersAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        OrderService::totalOrders($customer, 2020);

        $queryLog = DB::getQueryLog();

        $this->assertStringContainsString(
            'date(`orders`.`ordered_at`) >= ? and date(`orders`.`ordered_at`) <= ?',
            $queryLog[0]['query']
        );
    }

    public function testTotalOrdersCachesTheResult()
    {
        $customer = Customer::factory()->create();

        Cache::shouldReceive('remember')
            ->withSomeOfArgs(
                "customers.$customer->id.statistics.2022.total_orders",
                config('cache.ttl.customers.statistics'))
            ->once()
            ->andReturn(new stdClass());

        OrderService::totalOrders($customer, 2022);
    }
}
