<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_nummer',
        'datum_tijd',
        'verkoper_id',
        'koper_id',
        'product_id',
        'vestiging_id',
    ];

    public function koper(){
        return $this->belongsTo('App\Koper');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function verkoper(){
        return $this->belongsTo('App\Verkoper');
    }
}
