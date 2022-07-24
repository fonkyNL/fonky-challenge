<?php

namespace App\Console\Commands;

use App\Imports\OrdersImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:import {filePath?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the orders from a file';

    public function handle(): int
    {
        $filePath = $this->argument('filePath');
        if (! $filePath) {
            $filePath = $this->ask('Please specify the file path (from project root) to the import-file.', 'orders.csv');
        }

        if (! file_exists($filePath)) {
            $this->error('Could not find the given file');

            return 1;
        }

        Excel::import(new OrdersImport, $filePath);

        $this->info('Orders imported');

        return 0;
    }
}
