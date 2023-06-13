<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employeeOfTheMonth = $this->getEmployeeOfTheMonth();
        $sells = $this->getSells();
        // dd($sells);
        return view('home')->with([
            'empOfTheMonth' => $employeeOfTheMonth,
            'sells' => $sells
            ]
        );
    }

    private function getEmployeeOfTheMonth(){
        //Simple query that fetches the most occuring value of column koper in the Orders table
        return Order::select('koper')
        ->whereYear('created_at', '=', 2021) //the month and year values are set for testing. However they should be replaced by now() -1
        ->whereMonth('created_at', '=', 1)
        ->groupBy('koper')
        ->orderByRaw('COUNT(*) DESC')
        ->value('koper');
    }

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

    
}
