<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
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
    
    public function edit($id): View
    {   
        $order = Order::find($id);
        return view('Orders.createOrEdit')->with('order', $order);
    }

    public function update($id): View
    {   
        // dd($id);
        $order = Order::find($id);
        $order->koper = Request::input('Koper');
        $order->product = Request::input('product');
        $order->vestiging = Request::input('vestiging');
        $order->verkoper = Request::input('verkoper');

        $order->save();
        return view('Orders.index');


    }

    public function show($id): View
    {   
        dd('kkkk');
        // $order = Order::find($id);
        // return view('Orders.createOrEdit')->with('order', $order);
    }
    
    public function delte($id): View
    {   
        dd('kkkk');
        // $order = Order::find($id);
        // return view('Orders.createOrEdit')->with('order', $order);
    }


    
}
