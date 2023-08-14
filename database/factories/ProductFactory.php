<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'image1'           => 'p1.png',
            'name'            => $this->faker->word(),
            'category_id'     => rand(1, 4),
            'description'     => $this->faker->text(),
            'unit_price'           => rand(100, 120),
            'retailed_price'   => rand(10, 20),
            'stock'           =>  rand(20, 35),
        ];
    }
}
