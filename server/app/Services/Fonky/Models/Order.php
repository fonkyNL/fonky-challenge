<?php

namespace App\Services\Fonky\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $visible = [
        'order_id',
        'customer',
        'product',
        'seller',
        'created_at'
    ];

    protected function getCreatedAtAttribute($createdAt): string
    {
        return date('d/m/Y H:i', strtotime($createdAt));
    }

    public function pagination(int $resultPerPage): array
    {
        $pagination = Order::paginate($resultPerPage)->toArray();

        $pagination['next'] = ! is_null($pagination['next_page_url'])
            ? $pagination['current_page'] + 1
            : null;

        $pagination['previous'] = ! is_null($pagination['prev_page_url'])
            ? $pagination['current_page'] - 1
            : null;

        return $pagination;
    }
}
