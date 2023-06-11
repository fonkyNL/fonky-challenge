<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Tables\OrdersTable;


class OrdersController extends Controller
{


    public function index(): View
    {
        $table = new OrdersTable();
        return view('Orders.index');
    }
    
    public function edit(): View
    {
        dd('edit');
        // $orders = Order::all();
        return view('Orders.index');
    }


    
}
