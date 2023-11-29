<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    use HasFactory;
    protected $dates = [
        'expiration',

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
