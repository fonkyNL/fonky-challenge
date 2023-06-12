<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;

Route::get('/', function () {
    return view('welcome');
});

// Index route
Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');


// Create route
Route::get('orders/create', [OrdersController::class, 'create'])->name('orders.create');

// Store route
Route::get('orders/store', [OrdersController::class, 'store'])->name('orders.store');

// Show route
Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');



// Edit route
Route::get('orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');

// Update route
Route::put('orders/{order}', [OrdersController::class, 'update'])->name('orders.update');

// Delete route
Route::delete('orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');