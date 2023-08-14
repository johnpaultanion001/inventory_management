<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker;
use Illuminate\Support\Carbon;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory(50)->create()->each(function ($product) {
            $qty = rand(1, 15);
            $amt =  $qty *  $product->unit_price;

            \App\Models\Order::create([
                    'user_id' => 2,
                    'status' => "APPROVED",
                    'total_amount' => $amt,

                ])->each(function ($order) use ($product,$qty,$amt) {
                    $date = Carbon::create(2023, 1, 1, 0, 0, 0);
                    \App\Models\OrderProduct::create([
                        'user_id' => 2,
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                        'qty' =>  $qty,
                        'price' => $product->unit_price,
                        'discounted' => 0,
                        'amount' => $amt,
                        'product_name' => $product->name,
                        'status' => "APPROVED",
                        'created_at' => $date->addWeeks(rand(1, 52))->format('Y-m-d H:i:s'),
                    ]);
            });



        });

    }
}
