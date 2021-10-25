<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardOrdersPerPeriodeController extends Controller
{
    //
    public function index() {
                    
        $aantalOrdersPerMaand = DB::table('orders')
            ->selectRaw(DB::raw('COUNT(orderId) AS aantalOrders, SUBSTR(orderdatum,1,7) AS maand'))
            ->groupBy(DB::raw('SUBSTR(orderdatum,1,7)'))
            ->orderBy(DB::raw('SUBSTR(orderdatum,1,7)'))
            ->get();

        return view('dashboard.orders-per-periode', ['orders' => $aantalOrdersPerMaand]);
    }
}
