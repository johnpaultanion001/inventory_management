<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Traits\HandleDateParsing;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToCollection, WithHeadingRow
{
    use HandleDateParsing;

    public function collection(Collection $collection)
    {

        foreach ($collection as $row) {
            DB::beginTransaction();

            //$user = User::find(15);
            $cat = Category::where('name' ,$row['category'])->first();
            if($cat){
                $product_data = [
                    'stock' => 100,
                    'unit' => $row['unit'],
                    'code' => $row['code'],
                    'description' => $row['description'],
                    'area' => $row['area'],
                    'unit_price' => $row['unit_price'],
                    'price' => $row['price'],
                    'category_id' => $cat->id,
                    'expiration' => '2024/12/1',
                ];
            }else{
               $new_cat = Category::create([
                'name' => $row['category'],
               ]);

               $product_data = [
                'stock' => 250,
                'unit' => $row['unit'],
                'code' => $row['code'],
                'description' => $row['description'],
                'area' => $row['area'],
                'unit_price' => $row['unit_price'],
                'price' => $row['price'],
                'category_id' => $new_cat->id,
                'expiration' => '2024/12/1',
            ];
            }


            $order_products = [
                'product_code' => $row['code'],
                'description' => $row['description'],
                'qty' => $row['quantity'],
                'amount' => $row['amount'],
                'price' => $row['price'],
                'category' => $row['category'],
                'created_at' => rand(strtotime("Jan 01 2021"), strtotime("Nov 30 2023") ),
            ];

            $product = Product::updateOrCreate(
                [
                    'code' => $row['code'],
                ],
                $product_data

            );



            $orders = OrderProduct::create($order_products);
            DB::commit();
        }

    }
}
