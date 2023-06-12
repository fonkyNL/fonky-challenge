<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }


    public function fillFromCSVFile() {
        $csvFile = fopen("../orders.csv","r");
        echo "<table>\n";
        $data = fgetcsv($csvFile, 500, ",");
        echo "<tr>";
        for($i = 0; $i < count($data); $i++) {
            if ($i == 2 or $i == 4) {
                $array = explode('/', $data[$i]);
                foreach ($array as $item) {
                    echo "<th>".$item."</th>";
                }
            } else {
                echo "<th>" . $data[$i] . "</th>";
            }

        }
        echo "</tr>";
        while(($data = fgetcsv($csvFile, 500, ",")) !== FALSE) {
            $orderExists = Order::where('ID', intval($data[0]));
            if (!$orderExists->exists()) {
                $order = Order::create([
                    'ID' => intval($data[0]),
                    'Koper' => $data[1],
                    'Datum' => date('Y-m-d', strtotime(explode(' ', $data[2])[0])),
                    'Tijd' => explode(' ', $data[2])[1],
                    'Product' => $data[3],
                    'Vestiging' => explode('/', $data[4])[0],
                    'Verkoper' => explode('/', $data[4])[1]]
                );
            }
            echo "<tr>";
            for($i = 0; $i < count($data); $i++) {
                if ($i == 2) {
                    $array = explode(' ', $data[$i]);
                    foreach ($array as $item) {
                        echo "<td>".$item."</td>";
                    }
                } else if ($i == 4) {
                    $array = explode('/', $data[$i]);
                    foreach ($array as $item) {
                        echo "<td>".$item."</td>";
                    }
                } else {
                    echo "<td>" . $data[$i] . "</td>";
                }
            }

            echo "</tr>\n";
        }
        echo "</table>\n";
        fclose($csvFile);
    }

    public function orderInsights($fieldName) {
        $orders = Order::select($fieldName, DB::raw('count(*) as iCount'))
        ->groupBy($fieldName)
        ->get();
        return View::make("order-insights", compact('orders'));
    }
}
