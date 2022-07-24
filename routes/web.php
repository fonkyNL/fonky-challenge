<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn () => to_route('dashboard'));

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', DashboardController::class)
        ->name('dashboard');
});

require __DIR__.'/auth.php';
