<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name'
    ];
}
