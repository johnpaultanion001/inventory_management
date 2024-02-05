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
        'phy_add',
        'phy_minus',
        'bad_order',
        'isOrder',
        'expiration',
        'remarks',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code','code');
    }

}
