<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image1',
        'stock',
        'unit',
        'code',
        'description',
        'area',
        'unit_price',
        'price',
        'retailed_price',
        'category_id',
        'discount',
        'expiration',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function orders()
    {
        return $this->hasMany(OrderProduct::class, 'product_code' , 'code');
    }

    public function stocks()
    {
        return $this->hasMany(StockHistory::class, 'product_code' , 'code');
    }
}
