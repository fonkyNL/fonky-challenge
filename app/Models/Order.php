<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'id',
        'buyer_id',
        'product_id',
        'establishment_id',
        'seller_id',
        'created_at'
    ];

    protected $with = [ // All invoices need their relations
        'buyer',
        'seller',
        'product',
        'establishment'
    ];

    public function buyer(): HasOne
    {
        return $this->hasOne(Buyer::class);
    }

    public function seller(): HasOne
    {
        return $this->hasOne(Seller::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function establishment(): HasOne
    {
        return $this->hasOne(Establishment::class);
    }
}
