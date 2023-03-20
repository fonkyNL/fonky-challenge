<?php

declare(strict_types=1);

namespace App\Services\Metric;

final class MetricProviderFactory
{
    /**
     * @param MetricProviderInterface[] $providers
     */
    public function __construct(
        private iterable $providers
    ) {
    }

    public function getProviderByName(string $name): MetricProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->getMetricName() === $name) {
                return $provider;
            }
        }

        throw new MetricProviderResolutionException("Provider for metric '$name' not found.");
    }
}
