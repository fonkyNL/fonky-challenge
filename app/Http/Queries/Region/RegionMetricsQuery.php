<?php

declare(strict_types=1);

namespace App\Http\Queries\Region;

use App\Http\Requests\RegionMetricsRequest;
use App\Services\Metric\MetricProviderFactory;
use App\Services\Metric\MetricProviderResolutionException;
use Illuminate\Http\Exceptions\HttpResponseException;

final class RegionMetricsQuery
{
    public function __construct(
        private MetricProviderFactory $metricProviderFactory,
    ) {
    }

    public function __invoke(int $regionId, RegionMetricsRequest $request)
    {
        try {
            $provider = $this->metricProviderFactory->getProviderByName($request->metric);
        } catch (MetricProviderResolutionException $e) {
            throw new HttpResponseException(response()->json(['errors' => [$e->getMessage()]]));
        }

        $metric = $provider->calculateMetric($regionId);

        return response()->json([
            'data' => [
                'name' => $metric->name,
                'value' => $metric->value,
            ],
        ]);
    }
}
