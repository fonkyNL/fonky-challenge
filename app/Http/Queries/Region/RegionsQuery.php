<?php

declare(strict_types=1);

namespace App\Http\Queries\Region;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class RegionsQuery
{
    public function __invoke(): ResourceCollection
    {
        return RegionResource::collection(Region::all(['id', 'name']));
    }
}
