<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//orders
// Route::resource('orders', OrdersController::class);

// Index route
Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');

// Show route
Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');

// Create route
Route::get('/orders/create', [OrdersController::class, 'create'])->name('orders.create');

// Store route
// Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');

// Edit route
Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');

// Update route
Route::get('/orders/{order}/update', [OrdersController::class, 'update'])->name('orders.update');

// Delete route
Route::delete('/orders/{order}/delete', [OrdersController::class, 'destroy'])->name('orders.destroy');


