<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ordersFilePath = database_path('orders.csv');
        $ordersArray = [];

        Order::truncate();

        if (($orders = fopen($ordersFilePath, 'r')) !== false) {
            $header = fgetcsv($orders); // Read the header row

            while (($order = fgetcsv($orders)) !== false) {
                $branchAndSeller = explode('/', $order[4]);
                $branch = trim($branchAndSeller[0] ?? '');
                $seller = trim($branchAndSeller[1] ?? '');
                $date = Carbon::createFromFormat("d/m/Y H:i", $order[2] ?? '');
                $donation = str_replace(['D', ','], ['', '.'], $order[3] ?? '');

                $ordersArray[] = [
                    'id' => $order[0],
                    'buyer' => $order[1],
                    'date_sold' => $date->format("Y-m-d H:i") ?? now()->format('Y-m-d H:i'),
                    'donation' => floatval($donation),
                    'branch' => $branch,
                    'seller' => $seller,
                ];
            }

            fclose($orders);
        } else {
            Log::error('Something went wrong while parsing the csv file');
        }

        if ($ordersArray) {
            try {
                Order::insert($ordersArray);
            } catch (Throwable $e) {
                Log::error($e->getMessage());
            }
        }
    }
}
