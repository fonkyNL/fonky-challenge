<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verkoper extends Model
{
    use HasFactory;
    protected $fillable = ['naam'];

    public function orders(){
        return $this->hasMany('App\Order');
    }
}