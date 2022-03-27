<?php

namespace App\Http\Controllers;

use App\Models\Koper;
use App\Models\Order;
use App\Models\Product;
use App\Models\Verkoper;
use App\Models\Vestiging;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        dd($orders);
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_file' => 'required|mimes:csv|max:2048'
        ]);
        // dd($request->file());
        $file = $request->file('order_file');
        $filename = $file->getClientOriginalName();

        $location = 'uploads'; //Created an "uploads" folder for that
        // Upload file
        $file->move($location, $filename);
        $filepath = public_path($location . "/" . $filename);
        // Reading file
        $file = fopen($filepath, "r");
        $importData_arr = array(); // Read through the file and store the contents as an array
        $i = 0;
        //Read the contents of the uploaded file 
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            // Skip first row (Remove below comment if you want to skip the first row)
            if ($i == 0) {
                $i++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata[$c];
            }
            $i++;
        }
        fclose($file); //Close after reading

        // dd($importData_arr);

        $j = 0;
        foreach ($importData_arr as $importData) {
            $ordernummer = trim($importData[0]); //Get user names
            $import_koper = trim($importData[1]); //Get the user emails
            $datum_tijd = date('Y-m-d H:i:s', strtotime($importData[2])); //Get the user emails
            $import_product = trim($importData[3]); //Get the user emails
            $vestiging_verkoper = $importData[4]; //Get the user emails
            
            $vestiging_verkoper = explode('/', $vestiging_verkoper);
            $import_vestiging = trim($vestiging_verkoper[0]);
            $import_verkoper = trim($vestiging_verkoper[1]);

            // var_dump($ordernummer);
            // var_dump($import_koper);
            // var_dump($datum_tijd);
            // var_dump($import_product);
            // var_dump($import_verkoper);
            // var_dump($import_vestiging);

            // exit;

            $koper = Koper::firstOrCreate(['naam' => $import_koper]);
            $koper_id = $koper->id;
            // if($koper = Koper::whereRaw('naam = ?', [$import_koper])->first()){
            //     $koper_id = $koper->id;
            // } else {
            //     $koper = Koper::create(['naam' => $import_koper]);
            //     $koper_id = $koper->id;
            // }
            $product = Product::firstOrCreate(['naam' => $import_product]);
            $product_id = $product->id;
            $verkoper = Verkoper::firstOrCreate(['naam' => $import_verkoper]);
            $verkoper_id = $verkoper->id;
            $vestiging = Vestiging::firstOrCreate(['naam' => $import_vestiging]);
            $vestiging_id = $vestiging->id;

            $order = new Order;
            $order->order_nummer = $ordernummer;
            $order->datum_tijd = $datum_tijd;
            $order->koper_id = $koper_id;
            $order->verkoper_id = $verkoper_id;
            $order->product_id =$product_id;
            $order->vestiging_id =$vestiging_id;
            $order->save();

            $j++;
        }

        return back()
        ->with('success','File has been uploaded.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
