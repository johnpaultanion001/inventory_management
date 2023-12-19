<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'product_code',
        'unit',
        'qty',
        'unit_price',
        'total',
        'isConfirm',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code','code');
    }



    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
