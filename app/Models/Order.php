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

    public function kopers(){
        return $this->hasOne('App\Koper', 'foreign_key');
    }

    public function products(){
        return $this->hasOne('App\Product', 'foreign_key');
    }

    public function verkopers(){
        return $this->hasOne('App\Verkoper', 'foreign_key');
    }
}
