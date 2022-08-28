<?php
namespace App\Services\Fonky\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    protected $signature = 'fonky:install';

    protected $description = 'Install Fonky';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle(): void
    {
        $this->info('installing Fonky..');

        Artisan::call('key:generate', []);

        Artisan::call('migrate', []);

        Artisan::call('passport:install', []);

        Artisan::call('db:seed', []);

        $this->info('Done 🔥');
    }
}
