<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;
use App\Models\Order;
use App\Tables\OrdersTable;
use Illuminate\Support\Facades\Redirect;


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


    public function create(){
        return view('Orders.createOrEdit');
    }

    public function store(){
        $order = new Order();
        $order->koper = Request::input('Koper');
        $order->product = Request::input('product');
        $order->vestiging = Request::input('vestiging');
        $order->verkoper = Request::input('verkoper');
        $order->save();
        return Redirect::to('orders');
    }

    public function update($id)
    {   
        $order = Order::find($id);
        $order->koper = Request::input('Koper');
        $order->product = Request::input('product');
        $order->vestiging = Request::input('vestiging');
        $order->verkoper = Request::input('verkoper');
        $order->save();
        return Redirect::to('orders');
    }

    public function show($id): View
    {   
        $order = Order::find($id);
        return view('Orders.show')->with('order', $order);
    }
    
    public function destroy($id)
    {   
        Order::find($id)->delete();
        return Redirect::to('orders');
    }
    
    
}
