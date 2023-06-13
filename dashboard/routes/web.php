<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\HomeController;



//Home Routes
Route::get('/' , [HomeController::class, 'index']);
Route::get('best-sellers', [HomeController::class, 'showProducts'])->name('show-products');
Route::get('best-employees', [HomeController::class, 'showEmployees'])->name('show-employees');

///Orders routes
Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('orders/create', [OrdersController::class, 'create'])->name('orders.create');
Route::get('orders/store', [OrdersController::class, 'store'])->name('orders.store');
Route::get('orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
Route::get('orders/{order}/update', [OrdersController::class, 'update'])->name('orders.update');
Route::get('orders/destroy/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');
Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');