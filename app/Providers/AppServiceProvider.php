<?php

namespace App\Providers;

use App\Services\Metric\MetricProviderFactory;
use App\Services\Region\Metric\Providers\RegionRankProvider;
use App\Services\Region\Metric\Providers\RegionSalesRatioProvider;
use App\Services\Region\Metric\Providers\TotalSalesProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRegionMetrics();
    }

    private function registerRegionMetrics(): void
    {
        $this->app->bind(TotalSalesProvider::class);
        $this->app->bind(RegionSalesRatioProvider::class);
        $this->app->bind(RegionRankProvider::class);

        $this->app->tag([
            TotalSalesProvider::class,
            RegionSalesRatioProvider::class,
            RegionRankProvider::class,
        ], 'region_metrics');

        $this->app->bind(
            MetricProviderFactory::class,
            fn (Application $app) => new MetricProviderFactory($app->tagged('region_metrics')),
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
