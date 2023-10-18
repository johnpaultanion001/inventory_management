<?php

namespace App\Imports;

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
            $product_data = [
                'stock' => 250,
                'unit' => $row['unit'],
                'code' => $row['code'],
                'description' => $row['description'],
                'area' => $row['area'],
                'unit_price' => $row['unit_price'],
                'price' => $row['price'],
                'category_id' => "1",
            ];

            $order_products = [
                'product_code' => $row['code'],
                'description' => $row['description'],
                'qty' => $row['quantity'],
                'amount' => $row['amount'],
                'price' => $row['price'],
                'created_at' => $this->parseImportDate($row['order_date']),
            ];

            $stock_histories = [
                'product_code' => $row['code'],
                'stock' => 250,
            ];

            $product = Product::updateOrCreate(
                    [
                        'code' => $row['code'],
                    ],
                    $product_data

                );

            $stocks = \App\Models\StockHistory::updateOrCreate(
                [
                    'product_code' => $row['code'],
                ],
                $stock_histories

            );

            $orders = OrderProduct::create($order_products);

            DB::commit();

        }

    }
}
