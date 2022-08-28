<?php

namespace App\Services\Fonky\Actions\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TableHeader extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([
            [
                'label' => 'ID',
                'name' => 'order_id',
            ],
            [
                'label' => 'Koper',
                'name' => 'customer',
            ],
            [
                'label' => 'Product',
                'name' => 'product',
            ],
            [
                'label' => 'Vestiging / verkoper',
                'name' => 'seller',
            ],
            [
                'label' => 'Datum / tijd',
                'name' => 'created_at',
            ],
        ])
        ->setStatusCode(Response::HTTP_OK);
    }
}