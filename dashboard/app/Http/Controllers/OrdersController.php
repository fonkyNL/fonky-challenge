<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;


class OrdersController extends Controller
{


    public function index(): View
    {
        return view('Orders.index');
    }
    
}
