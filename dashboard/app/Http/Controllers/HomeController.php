<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sells = $this->getSells();
        return view('home')->with([
            'sells' => $sells
            ]
        );
    }

    public function showProducts() : View
    {
        $prodcuts = $this->getTopTen('product');
        return view('TopSellers.index')->with(['products' => $prodcuts]);
    }

    public function showEmployees() : View
    {
        $employees = $this->getTopTen('koper');
        return view('TopEmployees.index')->with(['employees' => $employees]);
        // return view('TopEmployees.index');
    }



///////////////////////////////Collection of Artifacts////////////////////////////

    private function getSells(){
        $rowsPerDay = Order::select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $result = [];
        foreach ($rowsPerDay as $row) {
            $result [$row->day] = $row->count;
        }
        return $result;
    }

    private function getTopTen($nameOfColumn)
    {
        $topTen = Order::select($nameOfColumn, DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', 2021) // Replace with desired year
            ->whereMonth('created_at', 1) // Replace with desired month
            ->groupBy($nameOfColumn)
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    
        $result = [];
        foreach ($topTen as $item) {
            $result[$item->$nameOfColumn] = $item->total;
        }
    
        return $result;
    }
    
}
