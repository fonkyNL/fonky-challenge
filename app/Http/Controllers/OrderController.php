<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Classes\Utility\CsvParser;

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

        $columnsToSplit = [2 => '/', 4 => '/'];
        $valuesToSplit = [2 => ' ', 4 => '/'];

        $csvArray = CsvParser::parseFileWithHeaders($csvFile, $columnsToSplit, $valuesToSplit);

        foreach ($csvArray as $row) {
            foreach ($row as $key => $value) {
                echo $key . ": " . $value ."<br>";
            }
            print_r($row);
            $orderExists = Order::where('ID', intval($row["﻿ID"]));
            if (!$orderExists->exists()) {
                $order = Order::create([
                    'ID' => intval($row['﻿ID']),
                    'Koper' => $row['Koper'],
                    'Datum' => date('Y-m-d', strtotime($row['Datum'])),
                    'Tijd' => $row['Tijd'],
                    'Product' => $row['Product'],
                    'Vestiging' => $row['Vestiging'],
                    'Verkoper' => $row['Verkoper']
                ]);
                echo "This Row was added<br>";
            } else {
                echo "This Row already exists<br>";
            }
            echo "==================<br>";
        }
        fclose($csvFile);
    }

    public function orderInsights($fieldName) {
        $orders = Order::select($fieldName, DB::raw('count(*) as iCount'))
        ->groupBy($fieldName)
        ->get();
        return View::make("order-insights", compact('orders'));
    }
}
