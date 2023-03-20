<?php

declare(strict_types=1);

namespace App\Services\Metric;

final class MetricDto
{
    public function __construct(
        public readonly string $name,
        public readonly int | float $value,
    ) {
    }
}
