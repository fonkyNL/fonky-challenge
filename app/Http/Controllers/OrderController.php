<?php

namespace App\Http\Controllers;

use App\Models\Koper;
use App\Models\Order;
use App\Models\Product;
use App\Models\Verkoper;
use App\Models\Vestiging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders as o')
                ->leftJoin('verkopers as vk', 'o.verkoper_id', '=', 'vk.id')
                ->leftJoin('products as p', 'o.product_id', '=', 'p.id')
                ->leftJoin('kopers as kp', 'o.koper_id', '=', 'kp.id')
                ->leftJoin('vestigings as ves', 'o.vestiging_id', '=', 'ves.id')
                ->select('o.id', 'o.order_nummer', 'o.datum_tijd', 
                        'vk.naam as verkoper', 'kp.naam as koper',
                        'p.naam as product', 'ves.naam as vestiging')
                ->simplePaginate(20);
        return view('order.index', compact('orders'));
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
        
        $file = $request->file('order_file');
        $filename = $file->getClientOriginalName();

        $location = 'uploads';
        // Upload file
        $file->move($location, $filename);
        $filepath = public_path($location . "/" . $filename);
        // Reading file
        $file = fopen($filepath, "r");
        $importData_arr = array();
        $i = 0;
        //Read the contents of the uploaded file 
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            // Skip first row
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

        $j = 0;
        foreach ($importData_arr as $importData) {
            $ordernummer = trim($importData[0]); 
            $import_koper = trim($importData[1]); 
            $import_product = trim($importData[3]);
            $vestiging_verkoper = $importData[4];
            
            $datum = explode('/', $importData[2]);
            $newDatum = $datum[0].'-'.$datum[1].'-'.$datum[2];
            $datum_tijd = date('Y-m-d H:i:s', strtotime($newDatum));
            
            $vestiging_verkoper = explode('/', $vestiging_verkoper);
            $import_vestiging = trim($vestiging_verkoper[0]);
            $import_verkoper = trim($vestiging_verkoper[1]);

            $koper = Koper::firstOrCreate(['naam' => $import_koper]);
            $koper_id = $koper->id;
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

    public function download(){
        $orders = DB::table('orders as o')
                ->leftJoin('verkopers as vk', 'o.verkoper_id', '=', 'vk.id')
                ->leftJoin('products as p', 'o.product_id', '=', 'p.id')
                ->leftJoin('kopers as kp', 'o.koper_id', '=', 'kp.id')
                ->leftJoin('vestigings as ves', 'o.vestiging_id', '=', 'ves.id')
                ->select('o.id', 'o.order_nummer', 'o.datum_tijd', 
                        'vk.naam as verkoper', 'kp.naam as koper',
                        'p.naam as product', 'ves.naam as vestiging')
                ->get();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        if(!File::exists(public_path().'/files')){
            File::makeDirectory(public_path().'/files');
        }

        $date = date('Ymd-His');
        $filename = public_path('files/orders'.$date.'.csv');
        $handle = fopen($filename, 'w');

        fputcsv($handle, [
            "ID",
            "Koper",
            "Datum / tijd",
            "Product",
            "Vestiging / verkoper",
        ]);

        foreach($orders as $order){
            fputcsv($handle, [
                $order->order_nummer,
                $order->koper,
                date('d/m/Y H:i:s', strtotime($order->datum_tijd)),
                $order->product,
                $order->vestiging.' / '.$order->verkoper
            ]);
        }
        fclose($handle);

        return response()->download($filename, 'orders'.$date.'.csv', $headers);
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
