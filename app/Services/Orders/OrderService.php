<?php

namespace App\Services\Orders;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use Carbon\Carbon;

class OrderService
{
    protected ?Customer $customer = null;

    protected ?Branch $branch = null;

    protected ?Buyer $buyer = null;

    protected ?Employee $employee = null;

    public function createOrder(?Carbon $orderedAt = null): Order
    {
        return Order::create([
            'customer_id' => $this->customer?->id,
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
}
