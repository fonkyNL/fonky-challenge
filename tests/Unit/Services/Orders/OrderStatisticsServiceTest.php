<?php

namespace Tests\Unit\Services\Orders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\Orders\OrderStatisticsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use stdClass;
use Tests\TestCase;

/** @group Services\OrderStatisticsServiceTest */
class OrderStatisticsServiceTest extends TestCase
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

        $result = (new OrderStatisticsService)->totalOrdersByProduct($customer);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]->total);
        $this->assertEquals('D10', $result[0]->name);
    }

    public function testTotalOrdersByProductAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        (new OrderStatisticsService)->totalOrdersByProduct($customer, 2020);

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

        (new OrderStatisticsService)->totalOrdersByProduct($customer, 2022);
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

        $result = (new OrderStatisticsService)->totalOrdersByBranch($customer);

        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]->total);
        $this->assertEquals('Utrecht', $result[0]->name);
    }

    public function testTotalOrdersByBranchAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        (new OrderStatisticsService)->totalOrdersByBranch($customer, 2020);

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

        (new OrderStatisticsService)->totalOrdersByBranch($customer, 2022);
    }

    public function testTotalOrdersReturnsATotal()
    {
        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
            )
            ->create();

        $result = (new OrderStatisticsService)->totalOrders($customer);

        $this->assertEquals(2, $result->total);
    }

    public function testTotalOrdersAcceptsAYear()
    {
        $customer = Customer::factory()->create();

        DB::enableQueryLog();
        (new OrderStatisticsService)->totalOrders($customer, 2020);

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

        (new OrderStatisticsService)->totalOrders($customer, 2022);
    }
}
