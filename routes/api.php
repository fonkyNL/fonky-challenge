<?php

use App\Http\Queries\Region\RegionMetricsQuery;
use App\Http\Queries\Region\RegionProductsQuery;
use App\Http\Queries\Region\RegionSellersQuery;
use App\Http\Queries\Region\RegionsQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/regions')->group(function () {
    Route::get('/{region}/metrics', RegionMetricsQuery::class);
    Route::get('/{region}/sellers', RegionSellersQuery::class);
    Route::get('/{region}/products', RegionProductsQuery::class);
    Route::get('/', RegionsQuery::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
