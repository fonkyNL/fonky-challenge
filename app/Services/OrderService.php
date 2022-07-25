<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrderService
{
    protected Customer $customer;

    protected ?Branch $branch;

    protected ?Buyer $buyer;

    protected ?Employee $employee;

    public function createOrder(?Carbon $orderedAt = null): Order
    {
        return Order::create([
            'customer_id' => $this->customer->id,
            'branch_id' => $this->branch?->id,
            'buyer_id' => $this->buyer?->id,
            'employee_id' => $this->employee?->id,
            'ordered_at' => $orderedAt ?? now(),
        ]);
    }

    public function forCustomer(string|Customer $customer): self
    {
        if ($customer instanceof Customer) {
            $this->customer = $customer;

            return $this;
        }

        $this->customer = Customer::firstOrCreate([
            'name' => $customer,
        ]);

        return $this;
    }

    public function atBranch(string|Branch $branch): self
    {
        if ($branch instanceof Branch) {
            $this->branch = $branch;

            return $this;
        }

        $this->branch = Branch::firstOrCreate([
            'name' => $branch,
            'location' => $branch,
        ]);

        return $this;
    }

    public function boughtBy(string|Buyer $buyer): self
    {
        if ($buyer instanceof Buyer) {
            $this->buyer = $buyer;

            return $this;
        }

        $this->buyer = Buyer::firstOrCreate([
            'name' => $buyer,
        ]);

        return $this;
    }

    public function soldBy(string|Employee $employee): self
    {
        if ($employee instanceof Employee) {
            $this->employee = $employee;

            return $this;
        }

        $this->employee = Employee::firstOrCreate([
            'name' => $employee,
        ]);

        return $this;
    }

    public static function totalOrdersByProduct(Customer $customer, ?int $year = null): Collection
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

    public static function totalOrdersByEmployee(Customer $customer, ?int $year = null): Collection
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

    public static function totalOrdersByBranch(Customer $customer, ?int $year = null): Collection
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

    public static function totalOrders(Customer $customer, ?int $year = null): stdClass
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
