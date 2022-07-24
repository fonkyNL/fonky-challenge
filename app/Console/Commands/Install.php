<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the current project!';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('migrate:fresh', ['--seed']);

        $this->call('make:user');

        $this->call('orders:import');

        return 0;
    }
}
