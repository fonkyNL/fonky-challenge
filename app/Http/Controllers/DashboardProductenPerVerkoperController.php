<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Order;

class DashboardProductenPerVerkoperController extends Controller
{
    //
    public function index() {
        return view('dashboard.producten-per-verkoper');
    }
}
