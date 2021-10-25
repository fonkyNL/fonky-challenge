<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardOverzichtController;
use App\Http\Controllers\DashboardOrdersPerPeriodeController;
use App\Http\Controllers\DashboardProductenPerVerkoperController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('order_list');
// });

Route::get('/'                      , [DashboardOverzichtController::class           , 'index']);
Route::get('/producten-per-verkoper', [DashboardProductenPerVerkoperController::class, 'index']);
Route::get('/orders-per-periode'    , [DashboardOrdersPerPeriodeController::class     , 'index']);
