<?php

declare(strict_types=1);

namespace App\Services\Region\Metric\Providers;

use App\Models\Order;
use App\Services\Metric\MetricDto;
use App\Services\Metric\MetricProviderInterface;

final class TotalSalesProvider implements MetricProviderInterface
{
    private const NAME = 'total_sales';

    public function getMetricName(): string
    {
        return self::NAME;
    }

    public function calculateMetric(int $entityId): MetricDto
    {
        $totalSales = Order::where('region_id', $entityId)->count();

        return new MetricDto(self::NAME, $totalSales);
    }
}
