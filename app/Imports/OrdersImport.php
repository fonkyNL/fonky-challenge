<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrdersImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct()
    {
        $this->customer = Customer::firstOrCreate([
            'name' => 'Test customer',
        ]);
    }

    /**
     * Imports are all done within transactions, no need to additionally create them.
     * https://docs.laravel-excel.com/3.1/imports/validation.html#database-transactions
     */
    public function collection(Collection $collection)
    {
        $collection->each(function (Collection $row) {
            $buyer = Buyer::firstOrCreate([
                'name' => $row->get('koper'),
            ]);

            $branch = Branch::firstOrCreate([
                'name' => $row->get('vestiging'),
                'location' => $row->get('vestiging'),
            ]);

            $employee = Employee::firstOrCreate([
                'name' => $row->get('verkoper'),
            ]);

            $order = Order::firstOrCreate([
                'id' => $row->get('id'),
                'customer_id' => $this->customer->id,
                'buyer_id' => $buyer->id,
                'branch_id' => $branch->id,
                'employee_id' => $employee->id,
                'ordered_at' => Carbon::createFromFormat('d/m/Y H:i', $row->get('datum_tijd')),
            ]);

            $product = Product::firstOrCreate([
                'name' => $row->get('product'),
            ]);

            $order->products()->attach($product);
        });
    }

    public function splitBranchAndName(string $branchAndNameString): array
    {
        return collect(explode('/', $branchAndNameString))
            ->map(fn ($stringWithSpaces) => trim($stringWithSpaces))
            ->toArray();
    }

    /*
     * The function that transforms the data that is received
     */
    public function prepareForValidation(array $data)
    {
        [$branchName, $employeeName] = $this->splitBranchAndName($data['vestiging_verkoper']);

        $data['vestiging'] = $branchName;
        $data['verkoper'] = $employeeName;

        unset($data['vestiging_verkoper']);

        return $data;
    }

    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer'],
            '*.koper' => ['required', 'string', 'max:255'],
            '*.datum_tijd' => ['required', 'date_format:d/m/Y H:i', 'after:01/01/1900 00:00', 'before:tomorrow'],
            '*.product' => ['required', 'string', 'max:255'],
            '*.vestiging' => ['required', 'string', 'max:255'],
            '*.verkoper' => ['required', 'string', 'max:255'],
        ];
    }
}
