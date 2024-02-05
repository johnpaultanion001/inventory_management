<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'supplier',
        'isRecieve',
    ];
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'purchase_order_id' , 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
