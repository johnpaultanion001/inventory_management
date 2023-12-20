<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\StockHistory;
use App\Models\OrderProduct;
use Faker;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products    = Product::latest()->get();

        foreach($products as $product){
            $qty = OrderProduct::where('product_code',$product->code)->sum('qty');
            $stockhistory[] = array(
                'product_code' => $product->code,
                'stock' => $qty,
                'stock_expi' => $qty,
                'isOrder' => false,
                'expiration' =>  '2024/12/1',
                'created_at' =>  '2023/10/1',
            );

            $stockhistory[] = array(
                'product_code' => $product->code,
                'stock' => 100,
                'stock_expi' => 100,
                'isOrder' => false,
                'expiration' =>  '2024/12/1',
                'created_at' =>  '2023/10/1',
            );
        };


        StockHistory::insert($stockhistory);

    }
}
