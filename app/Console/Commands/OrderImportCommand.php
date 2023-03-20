<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Region;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class OrderImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:import {filename : CSV-file name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import orders from CSV-file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $contents = Storage::drive('local')->get('data/' . $this->argument('filename'));

        $csv = Reader::createFromString($contents);

        $csv->setHeaderOffset(0);

        $progress = $this->output->createProgressBar($csv->count());

        foreach ($csv->getRecords(['id', 'customer', 'date', 'product', 'seller']) as $record) {
            [$region, $seller] = \explode('/', $record['seller']);

            $region = Region::updateOrCreate([
                'name' => \trim($region),
            ]);

            Order::updateOrCreate([
                'id' => $record['id'],
                'customer' => $record['customer'],
                'product' => $record['product'],
                'region_id' => $region->id,
                'seller' => \trim($seller),
                'date' => CarbonImmutable::createFromFormat('d/m/Y H:i', $record['date']),
            ]);

            $progress->advance();
        }

        $progress->finish();
    }
}
