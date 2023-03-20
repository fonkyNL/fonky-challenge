<?php

declare(strict_types=1);

namespace App\Services\Metric;

interface MetricProviderInterface
{
    public function getMetricName(): string;

    public function calculateMetric(int $entityId): MetricDto;
}
