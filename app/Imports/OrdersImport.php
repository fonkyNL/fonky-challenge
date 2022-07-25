<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Product;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrdersImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected Customer $customer;

    public function __construct()
    {
        $this->customer = Customer::firstOrCreate(['name' => 'Fonky Challenge Customer']);
    }

    /**
     * Imports are all done within transactions, no need to additionally create them.
     * Keep in mind that it does a single transaction per batch when using batches.
     * https://docs.laravel-excel.com/3.1/imports/validation.html#database-transactions
     */
    public function collection(Collection $collection): void
    {
        $collection->each(function (Collection $row) {
            (new OrderService())
                ->forCustomer($this->customer)
                ->atBranch($row->get('vestiging'))
                ->soldBy($row->get('verkoper'))
                ->boughtBy($row->get('koper'))
                ->createOrder(orderedAt: Carbon::createFromFormat('d/m/Y H:i', $row->get('datum_tijd')))
                ->products()
                ->attach(Product::firstOrCreate(['name' => $row->get('product')]));
        });
    }

    /**
     * Split the branch name and buyer name
     * Example: Nijmegen / Harry van der Hoeven
     * returns the following array:
     * [
     *   'Nijmegen',
     *   'Harry van der Hoeven'
     * ]
     */
    public function splitBranchAndName(string $branchAndNameString): array
    {
        return collect(explode('/', $branchAndNameString))
            ->map(fn ($stringWithSpaces) => trim($stringWithSpaces))
            ->toArray();
    }

    /*
     * Transform the data before it gets validated
     */
    public function prepareForValidation(array $data): array
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
