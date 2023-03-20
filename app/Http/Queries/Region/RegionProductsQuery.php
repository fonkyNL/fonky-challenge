<?php

declare(strict_types=1);

namespace App\Http\Queries\Region;

use App\Http\Resources\RegionProductResource;
use App\Repositories\RegionRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class RegionProductsQuery
{
    public function __construct(
        private RegionRepository $regionRepository,
    ) {
    }

    public function __invoke(int $regionId): ResourceCollection
    {
        $orders = $this->regionRepository->getRankedProductsWithTotalSalesForRegion($regionId);

        return RegionProductResource::collection($orders);
    }
}
