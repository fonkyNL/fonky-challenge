<?php

declare(strict_types=1);

namespace App\Services\Region\Metric\Providers;

use App\Models\Order;
use App\Services\Metric\MetricDto;
use App\Services\Metric\MetricProviderInterface;

final class RegionSalesRatioProvider implements MetricProviderInterface
{
    private const NAME = 'region_sales_ratio';

    public function __construct(
        private TotalSalesProvider $totalSalesProvider,
    ) {
    }

    public function getMetricName(): string
    {
        return self::NAME;
    }

    public function calculateMetric(int $entityId): MetricDto
    {
        $totalSales = Order::count();

        if ($totalSales === 0) {
            return new MetricDto(self::NAME, 0);
        }

        $regionTotalSales = $this->totalSalesProvider->calculateMetric($entityId);

        return new MetricDto(self::NAME, \round($regionTotalSales->value / $totalSales, 2));
    }
}
