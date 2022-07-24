<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Auth/Customer/Index', [
            'customers' => fn () => CustomerResource::collection(
                Customer::query()
                    ->withCount('orders')
                    ->when($request->search, fn ($query) => $query->where('name', 'LIKE', "$request->search%"))
                    ->cursorPaginate()
                    ->withQueryString()
            ),
            'filters' => $request->only(['search']),
        ]);
    }

    public function show(Request $request, Customer $customer)
    {
        $this->validate($request, [
            'year' => ['nullable', 'integer', 'min:1980', 'max:9999'],
        ]);

        return Inertia::render('Auth/Customer/Show', [
            'customer' => fn () => CustomerResource::make($customer),
            'customerStats' => fn () => [
                'total_orders_by_product' => CustomerService::totalOrdersByProduct($customer, $request->year),
                'total_orders_by_employee' => CustomerService::totalOrdersByEmployee($customer, $request->year),
                'total_orders_by_branch' => CustomerService::totalOrdersByBranch($customer, $request->year),
                'total_orders' => CustomerService::totalOrders($customer, $request->year),
            ],
        ]);
    }
}
