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
        $ordersArray = $this->parseOrdersCsv($ordersFilePath);

        if ($ordersArray) {
            $this->truncateOrdersTable();

            try {
                Order::insert($ordersArray);
            } catch (Throwable $e) {
                $this->logError('Failed to insert orders: ' . $e->getMessage());
            }
        }
    }

    /**
     * Parse the orders CSV file.
     *
     * @param string $filePath
     * @return array
     */
    protected function parseOrdersCsv(string $filePath): array
    {
        $ordersArray = [];

        if (($orders = fopen($filePath, 'r')) !== false) {
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
            $this->logError('Something went wrong while parsing the CSV file');
        }

        return $ordersArray;
    }

    /**
     * Truncate the orders table.
     */
    protected function truncateOrdersTable(): void
    {
        Order::truncate();
    }

    /**
     * Log an error message.
     *
     * @param string $message
     */
    protected function logError(string $message): void
    {
        Log::error($message);
    }
}
