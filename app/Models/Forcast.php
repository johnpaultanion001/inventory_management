<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'category',
        'total'
    ];
}
