<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RegionRepository
{
    public function getRankedSellersWithTotalSalesForRegion(int $regionId): Collection
    {
        return Order::where('region_id', $regionId)
            ->select(['seller', DB::raw('COUNT(id) as sales')])
            ->groupBy('seller')
            ->orderByRaw('sales DESC')
            ->get();
    }

    public function getRankedProductsWithTotalSalesForRegion(int $regionId): Collection
    {
        return Order::where('region_id', $regionId)
            ->select(['product', DB::raw('COUNT(id) as sales')])
            ->groupBy('product')
            ->orderByRaw('sales DESC')
            ->get();
    }
}
