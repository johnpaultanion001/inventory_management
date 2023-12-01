<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    protected $dates = [
        'expiration'  => 'date:Y-m-d',

    ];

    protected $fillable = [
        'product_code',
        'stock',
        'stock_expi',
        'isOrder',
        'expiration',
        'remarks',
    ];

}
