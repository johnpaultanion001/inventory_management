<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Size;
use App\Models\ShippingFee;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'              => 'CAN FOODS',

                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'SOFTDRINKS',

                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'SOLID FOODS',

                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],
            [
                'name'             => 'SNACKS',

                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at'          => date("Y-m-d H:i:s"),
            ],

        ];

        Category::insert($categories);

    }
}
