<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use League\Csv\Reader;

class OrderSeeder extends Seeder
{
    private array $columnNames = [
        'order_id',
        'customer',
        'created_at',
        'product',
        'seller'
    ];

    public function run(): void
    {           
        $csv = Reader::createFromPath(base_path('docs/orders.csv'), 'r');

        $csvRecords = $csv->getRecords(); 

        collect($csvRecords)->map(function (array $record) {
            return array_combine($this->columnNames, $record);
        })
        ->slice(1)
        ->map(function (array $record) {
            $record['order_id'] = (int) $record['order_id'];

            $date = preg_replace('/\//', '-', $record['created_at']);

            $record['created_at'] = date('Y-m-d H:i:s', strtotime($date));
             
            return $record;
        })
        ->each(function (array $order) {
            DB::table('orders')->insert($order);
        });
    }
}
