<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('../orders.csv');
        $orders = array_map('str_getcsv', file($csvFile));
        
        //skip column with columns' names
        array_shift($orders);
        //populate Orders table
        foreach ($orders as $order){
            $id = $order[0];
            $koper = $order[1];
            $created_at = \DateTime::createFromFormat('d/m/Y H:i', $order[2]);
            $product = $order[3];


            //break apart the seller data
            $sellerData = explode('/', $order[4]);

            $vestiging = trim($sellerData[0]);
            $verkoper = trim($sellerData[1]);

            DB::table('Orders')->insert([
                'id' => $id,
                'koper' => $koper,
                'created_at' => $created_at,
                'product' => $product,
                'vestiging' => $vestiging,
                'verkoper' => $verkoper,
            ]);
        }
        
    }
}
