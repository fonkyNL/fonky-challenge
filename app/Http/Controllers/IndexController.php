<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {
        return view('index', [
            'orders' => Order::orderBy('created_at', 'desc')->paginate(50)
        ]);
    }

    public function productchart()
    {
        return view('products');
    }

    public function buyerchart()
    {
        return view('buyers');
    }

    public function productData()
    {
        // Subquery because in strict mode all columns need to be in group by, which doesn't work for joins.
        return response()->json([
            'orders' => DB::table('orders')
                        ->select(DB::raw('count(*) as product_count, product_id, (select name from products where products.id = orders.product_id) as name'))
                        ->groupBy('product_id')
                        ->get()
        ]);
    }

    public function buyerData()
    {
        // Subquery because in strict mode all columns need to be in group by, which doesn't work for joins.
        return response()->json([
            'orders' => DB::table('orders')
                        ->select(DB::raw('count(*) as buyer_count, buyer_id, (select name from buyers where buyers.id = orders.buyer_id) as name'))
                        ->groupBy('buyer_id')
                        ->get()
        ]);
    }
}
