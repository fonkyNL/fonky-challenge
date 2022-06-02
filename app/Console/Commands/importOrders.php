<?php

namespace App\Console\Commands;

use App\Models\Buyer;
use App\Models\Establishment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Console\Command;

class importOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:import {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read csv file containing invoices into the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = getcwd() . '/' . $this->argument('file');

        $result = [];
        $handle = fopen($file, "r");
        if($handle) {
            $data = fgetcsv($handle);
            while ($data !== false) {
                $result[] = $data;
                $data = fgetcsv($handle);
            }
            fclose($handle);
        }

        array_shift($result); // Remove headers.

        $rows = collect($result);

        // We find all establishments and insert them.
        $establishments = [];
        $inserts = $rows->map(function ($row) {
            return trim(explode('/', $row[4])[0]);
        })->unique();
        foreach ($inserts as $insert) {
            $establishments[$insert] = Establishment::create([
                'name' => $insert
            ]);
        }

        // Find all sellers and insert them.
        $sellers = [];
        $inserts = $rows->map(function ($row) {
            return trim(explode('/', $row[4])[1]);
        })->unique();
        foreach ($inserts as $insert) {
            $sellers[$insert] = Seller::create([
                'name' => $insert
            ]);
        }

        // Find all products and insert them.
        $products = [];
        $inserts = $rows->map(function ($row) {
            return $row[3];
        })->unique();
        foreach ($inserts as $insert) {
            $products[$insert] = Product::create([
                'name' => $insert
            ]);
        }

        // Find all buyers and insert them.
        $buyers = [];
        $inserts = $rows->map(function ($row) {
            return $row[1];
        })->unique();
        foreach ($inserts as $insert) {
            $buyers[$insert] = Buyer::create([
                'name' => $insert
            ]);
        }

        // Insert all orders
        foreach ($rows as $row) {
            Order::create([
                'id' => $row[0],
                'buyer_id' => $buyers[$row[1]]->id,
                'product_id' => $products[$row[3]]->id,
                'establishment_id' => $establishments[trim(explode('/', $row[4])[0])]->id,
                'seller_id' => $sellers[trim(explode('/', $row[4])[1])]->id,
                'created_at' => Carbon::createFromFormat('d/m/Y H:i', $row[2])
            ]);
        }
        
        return 0;
    }
}
