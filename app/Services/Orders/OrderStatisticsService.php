<?php

namespace App\Services\Orders;

use App\Models\Customer;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrderStatisticsService
{
    public function totalOrdersByProduct(Customer $customer, ?int $year = null): Collection
    {
        return Cache::remember(
            key: "customers.$customer->id.statistics.$year.total_orders_by_product",
            ttl: config('cache.ttl.customers.statistics'),
            callback: fn () => DB::table('orders')
                ->selectRaw('COUNT(products.id) as total, products.name')
                ->join('order_product', 'orders.id', '=', 'order_product.order_id')
                ->join('products', 'products.id', '=', 'order_product.product_id')
                ->where('orders.customer_id', $customer->id)
                ->when(
                    value: $year,
                    callback: fn (Builder $query) => $query
                        ->whereDate('orders.ordered_at', '>=', "$year-01-01")
                        ->whereDate('orders.ordered_at', '<=', "$year-12-31")
                )
                ->groupBy('products.id')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }

    public function totalOrdersByEmployee(Customer $customer, ?int $year = null): Collection
    {
        return Cache::remember(
            key: "customers.$customer->id.statistics.$year.total_orders_by_employee",
            ttl: config('cache.ttl.customers.statistics'),
            callback: fn () => DB::table('orders')
                ->selectRaw('COUNT(employees.id) as total, employees.name')
                ->join('employees', 'orders.employee_id', '=', 'employees.id')
                ->where('orders.customer_id', $customer->id)
                ->when(
                    value: $year,
                    callback: fn (Builder $query) => $query
                        ->whereDate('orders.ordered_at', '>=', "$year-01-01")
                        ->whereDate('orders.ordered_at', '<=', "$year-12-31")
                )
                ->groupBy('employees.id')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }

    public function totalOrdersByBranch(Customer $customer, ?int $year = null): Collection
    {
        return Cache::remember(
            key: "customers.$customer->id.statistics.$year.total_orders_by_branch",
            ttl: config('cache.ttl.customers.statistics'),
            callback: fn () => DB::table('orders')
                ->selectRaw('COUNT(branches.id) as total, branches.name')
                ->join('branches', 'orders.branch_id', '=', 'branches.id')
                ->where('orders.customer_id', $customer->id)
                ->when(
                    value: $year,
                    callback: fn (Builder $query) => $query
                        ->whereDate('orders.ordered_at', '>=', "$year-01-01")
                        ->whereDate('orders.ordered_at', '<=', "$year-12-31")
                )
                ->groupBy('branches.id')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
        );
    }

    public function totalOrders(Customer $customer, ?int $year = null): stdClass
    {
        return Cache::remember(
            key: "customers.$customer->id.statistics.$year.total_orders",
            ttl: config('cache.ttl.customers.statistics'),
            callback: fn () => DB::table('orders')
                ->selectRaw('COUNT(orders.id) as total')
                ->where('orders.customer_id', $customer->id)
                ->when(
                    value: $year,
                    callback: fn (Builder $query) => $query
                        ->whereDate('orders.ordered_at', '>=', "$year-01-01")
                        ->whereDate('orders.ordered_at', '<=', "$year-12-31")
                )
                ->first()
        );
    }
}
