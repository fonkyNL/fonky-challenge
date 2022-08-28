<?php

namespace App\Services\Fonky\Actions\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Fonky\Models\Order;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TableRows extends Controller
{
    public function __invoke(Order $order): JsonResponse
    {
        $orders = $order->pagination(10);

        return response()->json($orders)->setStatusCode(Response::HTTP_OK);
    }
}