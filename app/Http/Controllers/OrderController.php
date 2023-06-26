<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetOrdersRequest;
use App\Http\Resources\DonationSummaryResource;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Method: GET
     * Route: /api/v1/orders
     * @param GetOrdersRequest $request
     * @return JsonResource
     */
    public function orders(GetOrdersRequest $request): JsonResource
    {
        $data = $request->validated();
        return DonationSummaryResource::collection($this->order->getDonationMetric($data['supplier'], $data['type']));
    }
}
