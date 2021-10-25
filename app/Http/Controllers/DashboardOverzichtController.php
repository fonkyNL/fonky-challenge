<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Order;

class DashboardOverzichtController extends Controller
{
    //
    public function index() {
        return view('dashboard.overzicht', ['orders' => Order::all()]);
    }
}
