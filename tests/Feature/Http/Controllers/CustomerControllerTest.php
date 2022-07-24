<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

/** @group Controllers\CustomerControllerTest */
class CustomerControllerTest extends TestCase
{
    public function testItCannotAccessIndexWhenUnauthenticated()
    {
        $this->get(route('customer.index'))
            ->assertRedirect(route('login'));
    }

    public function testItCannotAccessShowWhenUnauthenticated()
    {
        $this->get(route('customer.index'))
            ->assertRedirect(route('login'));
    }

    public function testItCanAccessTheCustomersIndex()
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('customer.index'))
            ->assertOk();
    }

    public function testItCanDisplayTheCustomersOnIndex()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->create([
            'name' => 'ABC',
        ]);

        $this->get(route('customer.index'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                    ->where('name', 'ABC')
                    ->etc()
                )
            );
    }

    public function testItFetchesTheTotalAmountOfOrdersOnIndex()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()
            ->has(Order::factory())
            ->create([
                'name' => 'ABC',
            ]);

        $this->get(route('customer.index'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                    ->where('orders_count', 1)
                    ->etc()
                )
            );
    }

    public function testItCanFilterTheCustomersIndex()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->create([
            'name' => 'ABC',
        ]);

        Customer::factory()->create([
            'name' => 'XYZ',
        ]);

        $this->get(route('customer.index', ['search' => 'xyz']))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('customers.data', 1, fn (AssertableInertia $page) => $page
                    ->where('name', 'XYZ')
                    ->etc()
                )
            );
    }

    public function testItSendsAPaginatedResourceOnIndex()
    {
        $this->actingAs(User::factory()->create());

        Customer::factory()->create([
            'name' => 'ABC',
        ]);

        $this->get(route('customer.index', ['search' => 'xyz']))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('customers', fn (AssertableInertia $page) => $page
                    ->hasAll(['data', 'links', 'meta'])
                )
            );
    }

    public function testItCanAccessTheCustomerShow()
    {
        $this->actingAs(User::factory()->create());

        $customer = Customer::factory()->create([
            'name' => 'ABC',
        ]);

        $this->get(route('customer.show', $customer->id))
            ->assertOk();
    }

    public function testItGetsTheCustomersStatsOnShow()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();

        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
                    ->hasAttached($product)
                    ->for(Branch::factory())
                    ->for(Employee::factory())
                    ->for(Buyer::factory())
            )
            ->create();

        $this->get(route('customer.show', $customer->id))
            ->assertInertia(fn (AssertableInertia $page) => $page

                ->has('customerStats', fn (AssertableInertia $page) => $page
                    ->where('total_orders_by_product.0.total', 2)
                    ->where('total_orders_by_employee.0.total', 2)
                    ->where('total_orders_by_branch.0.total', 2)
                    ->where('total_orders.total', 2)
                )
            );
    }

    public function testItCanFilterByYearOnShow()
    {
        $this->actingAs(User::factory()->create());

        $searchDate = today()->subYears(2);

        $customer = Customer::factory()
            ->has(
                Order::factory()
                    ->count(2)
                    ->state(new Sequence(
                        ['ordered_at' => now()],
                        ['ordered_at' => $searchDate]
                    ))
            )
            ->create();

        $this->get(route('customer.show', ['customer' => $customer->id, 'year' => $searchDate->year]))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->has('customerStats', fn (AssertableInertia $page) => $page
                    ->where('total_orders.total', 1)
                    ->etc()
                )
            );
    }
}
