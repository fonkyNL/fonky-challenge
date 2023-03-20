<?php

declare(strict_types=1);

namespace App\Services\Region\Metric\Providers;

use App\Services\Metric\MetricDto;
use App\Services\Metric\MetricProviderInterface;
use Illuminate\Support\Facades\DB;

final class RegionRankProvider implements MetricProviderInterface
{
    private const NAME = 'region_rank';

    public function getMetricName(): string
    {
        return self::NAME;
    }

    public function calculateMetric(int $entityId): MetricDto
    {
        $result = DB::select(
            <<<SQL
            WITH sales_rankings AS (
                SELECT
                    region_id,
                    RANK() OVER (ORDER BY COUNT(id) DESC) position
                FROM orders
                GROUP BY region_id
            )
            SELECT position FROM sales_rankings WHERE region_id = :region LIMIT 1
            SQL,
            ['region' => $entityId],
        );

        $position = $result[0]?->position ?? 0;

        return new MetricDto(self::NAME, (int) $position);
    }
}
